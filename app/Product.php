<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Validator;

class Product extends Model
{

    const PROD_NORMAL = '0';

    const PROD_VARIABLE = '1';

    const PROD_COMPL = '2';

    const PROD_COMBO = '3';

    protected $table = "product";

    protected $fillable = [

        'product_pic_src',

        'name_product',

        'description_product',

        'price_product',

        'status_product',

        'category_id',

        'promotion_active',

        'product_lojas_id',

        'product_type',

        'promotion_day',

        'promotion_price',

        'product_order',

        'product_comps',

        'combo_id'

    ];

    private $validator;

    public function __construct(array $attributes = [])

    {

        $this->validator = Validator::make([], []);
    }

    static $images_storage_path = 'media/product';

    public static function getPromoProducts($lojaId = null)
    {
        if($lojaId)
        {
            
            $day = new \DateTime('now');
    
            $promo = self::select('*')
                ->where('product_lojas_id', 'like', '%' . $lojaId . '%')
                ->where('promotion_active', '=', '1')
                ->where('promotion_day', '=', $day->format('w'))->orWhere('promotion_day', '=', 7)
                ->where('status_product', '=', '1')
                ->get();

        }
        else
        {
            $day = new \DateTime('now');
    
            $promo = self::select('*')
                ->where('promotion_active', '=', '1')
                ->where('promotion_day', '=', $day->format('w'))->orWhere('promotion_day', '=', '7')
                ->where('status_product', '=', '1')
                ->get();
        }

        return $promo;
    }

    public function productCategories()
    {

        return $this->hasOne(ProductCategories::class, 'id', 'category_id');
    }

    /**

     * Checks if this offer has a image defined

     * @return bool true if the image_filename is defined or false otherwise

     */

    public function hasImage()
    {

        return $this->product_pic_src && !empty($this->product_pic_src);
    }

    /**

     * Returns the Path of the image or null in case the image_file attribute is not set or empty.

     * Internally, uses hasImage function to verify this question

     * @return string|null

     */
    public function getImagePath()
    {

        if (!$this->hasImage()) {

            return null;
        }

        return self::$images_storage_path . '/' . $this->product_pic_src;
    }

    /**

     * Returns the URL of the image or null in case the image_file attribute is not set or empty.

     * Internally, uses hasImage function to verify this question

     * @return string|null

     */

    public function getImageURL()
    {

        return $this->hasImage() ? \Storage::url($this->getImagePath()) : null;

        //return $this->product_pic_src;
    }

    static public function getProducts()
    {
        $category = Product::all()->pluck('category_id')->unique();
        $produtos = null;
        //Novos testes apartir daki
        foreach($category as $categoria){
        $produtos[$categoria] = Product::all()->where('category_id', '==', $categoria)->pluck('name_product','id');
        }
        
        
        return $produtos;
        
        
        
        //Fim dos novos testes
        //parte funcional acima
        //parte antiga e de testes abaixo
        
        
        
        // $allProducts = Product::all()->where('category_id', '==', 4)->pluck('name_product','id');
            
        // daki para baixo retirar para o della monica
        //   $i =0;
          
    //     $produtos['Pizzas'] = array('inicio so para criar o array Pizza vai ser apagado no Shift');
        
    //     $produtos['Bordas'] = array('inicio so para criar o array Bordas vai ser apagado no Shift');
         
    //      $produtos[1]= $allProducts[14];
        
         
         
    //   //dd($allProducts);
  
    //     foreach($category as $pizza){

    //         //aki ele pergunta a categoria do produto, se for 1 = pizza se for 2 = borda
    //         if($pizza == "5"){
    //         array_push($produtos['Pizzas'], $allProducts[$i] );
          
    //         }
            
    //          elseif($pizza == 4){

    //          array_push($produtos['Bordas'], $allProducts[$i] );

    //           // print_r($test[$i]);
    //          }
    //         $i++;
        
       
       
    //     // foreach($category as $pizza){

            
    //     //     if($pizza == 1){
    //     //     $product = $product + array("pizza".$i => array($test[$i]));
           
             
    //     //     }
    //     //     elseif($pizza ==2){

    //     //     $product = $product + array('borda' => array($test[$i]));

    //     //        // print_r($test[$i]);
    //     //     }
    //     //     $i++;
    //      }
         
        
    //     array_shift($produtos['Pizzas']);
    //     array_shift($produtos['Bordas']);
        
        

       
    }
    static public function getProductsForAjax()
    {
        $category = Product::all()->pluck('category_id')->unique();
        
        //Novos testes apartir daki
        foreach($category as $categoria){
        $produtos[$categoria] = Product::all()->where('category_id', '==', $categoria)->pluck('combo_id','id');
        }
        
        
        return $produtos;
       
    }

    public function getPromotionPrice()
    {

        return $this->hasOne(ProductPromotion::class, 'id', 'promotion_id');
    }
    public static function findCombo($var)
    {
        
        $i=0;
        foreach($var as $combo){
            
            $produto[$i] = Product::find($combo);
            $i++;
        }
        
        return $produto;
    }

    public function getCategory()
    {

        return $this->hasOne(ProductCategories::class, 'id', 'category_id');
    }

    public function validate($new = true)
    {
        // create a new Validator, as we need a fresh $validate->failed() errors on each call to validate()

        // for specific rule error check

        $rules = $new ? $this->validationRules() : $this->updateValidationRules();

        $this->validator = Validator::make($this->attributes, $rules);

        return !$this->validator->fails();
    }

    /**

     * Validator errors

     * @return MessageBag

     */
    public function getErrors()
    {

        return $this->validator->errors();
    }

    private function updateValidationRules()
    {

        $updateRules = $this->validationRules();

        $updateRules['name_product'] = 'required';

        $updateRules['description_product'] = 'required';

        $updateRules['price_product'] = 'required';

        $updateRules['status_product'] = 'required';

        $updateRules['category_id'] = 'required';

        $updateRules['promotion_active'] = 'required';

        $updateRules['product_lojas_id'] = 'required';

        $updateRules['product_type'] = 'required';

        $updateRules['promotion_price'] = 'required';

        $updateRules['promotion_day'] = 'required';

        return $updateRules;
    }

    private function validationRules()
    {

        return [

            'product_pic_src' => 'nullable',

            'name_product' => 'required',

            'description_product' => 'required',

            'price_product' => 'required',

            'status_product' => 'required',

            'category_id' => 'required',

            'promotion_active' => 'required',

            'product_lojas_id' => 'required',

            'product_type' => 'required',

            'promotion_price' => 'required',

            'promotion_day' => 'required'

        ];
    }
}
