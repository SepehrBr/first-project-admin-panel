<?php  namespace Modules\Cart\Helpers;
       use Illuminate\Database\Eloquent\Model;
       use Illuminate\Support\Facades\Cookie;
       use Illuminate\Support\Str;
       use Modules\Discount\Entities\Discount;

class CartService
{
    protected $cart;
    protected $name = 'default';
    public function __construct() {
        // $this->cart = session()->get($this->name) ?? collect([]);
    // as cookie
        $cart = collect(json_decode(request()->cookie($this->name), true));
        $this->cart = $cart->count() ? $cart : collect([
            'items' => [],
            'discount' => null
        ]);
    }

    /**
     * @param array $value
     * @param null $obj
     * @return $this
     */
    public function put(array $value, $object = null)
    {
        if (!is_null($object) && $object instanceof Model) {
            $value = array_merge($value, [
                'id' => \Str::random(10),

            // this is being used for polymorphic relations if needed
                'subject_id' => $object->id,
                'subject_type' => get_class($object),
                'discount_percent' => 0
            ]);
        } elseif (!isset($value['id'])) {
            $value = array_merge($value, [
                'id' => \Str::random(10),
            ]);
        }

    // to add in cart
        $this->cart['items'] = collect($this->cart['items'])->put($value['id'], $value);

    // save cart in session even after being refreshed
        // session()->put($this->name, $this->cart);

    // saving cart in Coockie instead of session
        Cookie::queue($this->name, $this->cart->toJson(), 60 * 24 * 2);
        /*
            1) to use session->put as cookie you should use => Cookie::queue()
            2) if $this->cart is collecction remember to parse it into json
            3) cookie expiration time is in minutes now in example above we had set cookie value until two days
        */
        return $this;
    }
    public function has($key)
    {
        // check if key is OOP =>
        if ($key instanceof Model) {
            return ! is_null(collect($this->cart['items'])->where('subject_id', $key->id)->where('subject_type', get_class($key))->first());
        }

        // check if key is \Str::random(10) =>
        return ! is_null(collect($this->cart['items'])->where('id', $key)->first());
    }
    public function get($key, $relationExist = true)
    {
        $item = $key instanceof Model
                        ? collect($this->cart['items'])->where('subject_id', $key->id)->where('subject_type', get_class($key))->first()
                        : collect($this->cart['items'])->where('id', $key)->first();

        return $relationExist ? $this->checkRelationExists($item) : $item;
    }
    public function all()
    {
        $cart = $this->cart;
        $cart = collect($this->cart['items'])->map(function ($item) use ($cart) {
            $item = $this->checkRelationExists($item);

            // add discount value
            $item = $this->addDiscountValue($item, $cart['discount']);

            return $item;
        });
        // dd($cart);

        return $cart;
    }
    public function update($key, $options)
    {
    // first select item
        $item = collect($this->get($key, false));

    // check if item exsist or not
        if (is_null($item)) throw new \Exception("Cart is Empty");

    // update item if ...
        if (is_numeric($options)) {
            $item = $item->merge(
                [
                    'quantity' => $item['quantity'] + $options
                ]
            );

        }
        if (is_array($options)) {
            $item = $item->merge($options);
        }
    // update cart using put
        $this->put($item->toArray());

        return $this;

    }
    public function delete($key)
    {
        if ($this->has($key)) {
            $this->cart['items'] = collect($this->cart['items'])->filter(function ($item) use ($key) {
                if ($key instanceof Model) {
                    return $item['subject_id'] != $key->id && $item['subject_type'] != get_class($key) ;
                }

                return $key != $item['id'];
            });

            // session()->put($this->name, $this->cart);

        // if you wanr to save in cookie =>
            Cookie::queue($this->name, $this->cart->toJson(), 60 * 24 * 2);

            return true;
        }

        return false ;
    }
    public function count($key)
    {
        return ($this->has($key)) ? $this->get($key)['quantity'] : 0;
    }

    protected function checkRelationExists($item)
    {
        if (isset($item['subject_id']) && isset($item['subject_type'])) {
            $class = $item['subject_type'];
            $subject = (new $class())->find( $item['subject_id'] );
            $item[strtolower(class_basename($class))] = $subject;

            unset($item['subject_id']);
            unset($item['subject_type']);

            return $item;
        }

        return $item;
    }

// multiple cart methods
    public function instance(string $name)
    {
        // $this->cart = session()->get($name) ?? collect([]);
    // as cookie
        $cart = collect(json_decode(request()->cookie($name), true));
        $this->cart = $cart->count() ? $cart : collect([
            'items' => [],
            'discount' => null
        ]);
        $this->name = $name;
        return $this;
    }

    public function flush()
    {
        $this->cart = collect([
            'items' => [],
            'discount' => null
        ]);
        Cookie::queue($this->name, $this->cart->toJson(), 60 * 24 * 2);
        return $this;
    }

    // discount methods
    public function addDiscount($code)
    {
        $this->cart['discount'] = $code;
        Cookie::queue($this->name, $this->cart->toJson(), 60 * 24 * 2);
    }
    protected function addDiscountValue($item, $discount)
    {
        $discount = Discount::whereCode($discount)->first();

        if ($discount && $discount->expired_at > now()) {
            if (
                (!$discount->products->count() && !$discount->categories->count()) ||
                in_array($item['product']->id, $discount->products->pluck('id')->toArray()) ||
                array_intersect($item['product']->categories->pluck('id')->toArray(), $discount->categories->pluck('id')->toArray())
                ) {
                $item['discount_percent'] = $discount->percent / 100;
            }
        }

        return $item;
    }

    public function getDiscountCode()
    {
        return Discount::whereCode($this->cart['discount'])->first();
    }
}
