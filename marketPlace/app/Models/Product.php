<?php

namespace App\Models;

use App\Models\Image;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
  use HasFactory;
  protected $fillable = [
    'name',
    'description',
    'price',
    'url'
  ];

  /**
   * This function defines a many-to-many relationship between the current model and the Category model
   * in PHP, with timestamps enabled.
   * 
   * @return The `categories()` function is returning a many-to-many relationship between the current
   * model and the `Category` model. It is using the `belongsToMany()` method to define the
   * relationship and the `withTimeStamps()` method to automatically manage the timestamps of the pivot
   * table.
   */
  public function categories()
  {
    return $this->belongsToMany(Category::class)->withTimeStamps();
  }

  /**
   * This function defines a one-to-many relationship between a product and its images in a PHP class.
   * 
   * @return The `productImages()` function is returning a `hasMany` relationship between the current
   * model and the `ProductImage` model. This means that the current model can have multiple instances
   * of the `ProductImage` model associated with it.
   */
  public function productImages()
  {
    return $this->hasMany(ProductImage::class);
  }

  /**
   * This PHP function returns a collection of images associated with a product.
   * 
   * @return The `getImages()` function is returning a collection of images associated with a product.
   * It uses the `productImages()` relationship to retrieve the images and the `pluck()` method to
   * extract only the `image` attribute from each image.
   */
  public function getImages()
  {
    return $this->productImages()->with('images')->get()->pluck('Image');
  }

  /**
   * This function adds an image to a product and sets it as the main image if specified.
   * 
   * @param Image image The  parameter is an instance of the Image class, which is being passed
   * as an argument to the addImage() function. It is assumed that the Image class has properties and
   * methods that allow for the creation and manipulation of image files.
   * @param isMain The "isMain" parameter is a boolean value that indicates whether the image being
   * added is the main image for the product or not. If it is set to true, it means that this image
   * will be displayed as the primary image for the product.
   */
  public function addImage(Image $image, $isMain)
  {
    Image::factory()->create($image);

    ProductImage::factory()->create([
      'isMain' => $isMain,
      'product_id' => $this->id,
      'image_id' => $image->id
    ]);
  }

  /**
   * This PHP function retrieves the URL of the main image of a product.
   * 
   * @return The `getMainImage()` function returns the URL of the main image of a product, or `null` if
   * there is no main image.
   */
  public function getMainImage()
  {

    try {
      $productImage =
        ProductImage::all()
        ->where('isMain', true)
        ->where('product_id', $this->id)->first();

      $mainImage = DB::table('images')
        ->where('images.id', '=', $productImage->image_id)->first();

      return strval($mainImage->url);
    } catch (\Throwable $th) {
      $productImage =
        ProductImage::all()
        ->where('isMain', false)
        ->where('product_id', $this->id)->first();

      $alternativeImage = DB::table('images')
        ->where('images.id', '=', $productImage->image_id)->first();

      return $alternativeImage == null || $alternativeImage->url == null ? null : strval($alternativeImage->url);
    }
  }

  public function getAlternativeImages()
  {
    $productImage = ProductImage::all()
      ->where('isMain', false)
      ->where('product_id', $this->id)->all();

    $images = [];

    foreach ($productImage as $proImg) {
      $i = DB::table('images')->where('images.id', '=', $proImg->image_id)->first();
      array_push($images, $i->url);
    }

    return $images;
  }

  /**
   * This PHP function searches for products by name and returns them in a paginated format, with an
   * optional sorting order.
   * 
   * @param request The  parameter is an array that contains the search and order parameters.
   * 
   * @return a paginated list of products filtered by name, sorted by name in ascending or descending
   * order based on the value of the `` parameter. The search is performed using the `LIKE`
   * operator to match the `` parameter with the `name` column of the `products` table. The
   * function also eager loads the `categories` relationship for each product.
   */

  public static function searchByName($request)
  {
    $fieldSearch = $request['search'];
    $order = $request['order'];
    $order = empty($request['order']) ? 'ASC' : $request['order'];

    return $productsFilter = Product::with('categories')->where('name', 'LIKE', '%' . $fieldSearch . '%')
      ->where('isVisible', '=', 1)
      ->where('isDeleted', '=', 0)
      ->where('selled_at', '=', NULL)
      ->orderBy('name', $order)
      ->paginate(env('PAGINATE', 10));
  }

  /**
   * The function takes an ID string, splits it into individual characters, and returns an array of
   * Product objects that match each character.
   * 
   * @param id The parameter `` is a string that contains one or more product IDs separated by dots.
   * The function `getInfoFromId` splits the string into an array of individual IDs and retrieves
   * information about each product from a database using the `Product` model. The function then
   * returns an array of `
   * 
   * @return an array of Product objects that match the IDs passed in as a parameter.
   */
  public static function getInfoFromId($id)
  {
    $products = array();
    $idArray = explode('.', $id);
    foreach ($idArray as $char) {
      if ($char != "") {
        array_push($products, Product::all()->where("id", $char)->first());
      }
      //array_push($products, Product::all()->where("id", $value)->first());
    }
    return $products;
  }


  /**
   * This function searches for products based on a given search term, category, and order, and returns
   * the results.
   * 
   * @param request The  parameter is an array that contains the search query parameters such
   * as 'search', 'category', and 'order'.
   * 
   * @return the result of the method `getAllSearchedProducts()` with the parameters ``,
   * ``, ``, and ``.
   */
  public static function searchByAll($request)
  {
    $fieldSearch = $request['search'];
    $category = $request['category'];
    $order = $request['order'];
    $order = empty($request['order']) ? 'ASC' : $request['order'];

    $subcategoriesName = Category::getSubCategories($category)->pluck('name')->toArray();

    $searchName = explode(' ', $fieldSearch);
    $fieldCamps = array_merge($searchName, $subcategoriesName);


    return self::getAllSearchedProducts($searchName, $category, $fieldCamps, $order);
  }

  /**
   * This function retrieves searched products based on search name, category, field camps, and order.
   * 
   * @param searchName The name of the product being searched for.
   * @param category The category parameter is a string that represents the category of products to
   * search for. It is used in the database query to filter the results by category.
   * @param fieldCamps It seems that "fieldCamps" is an array of search terms or keywords that are used
   * to search for products in the database. The function loops through each search term and performs a
   * database query to find products that match the search term.
   * @param order The order parameter is a string that specifies the order in which the search results
   * should be sorted. It can be either 'ASC' for ascending order or 'DESC' for descending order.
   * 
   * @return a LengthAwarePaginator object that contains a collection of products that match the search
   * criteria specified in the function parameters. The products are sorted based on the order
   * parameter (either ascending or descending) and are paginated based on the PAGINATE environment
   * variable or a default value of 10.
   */
  public static function getAllSearchedProducts($searchName, $category, $fieldCamps, $order)
  {
    $result = new Collection();
    for ($i = 0; $i < count($fieldCamps); $i++) {
      $p = Product::join('category_product', 'products.id', '=', 'category_product.id')
        ->where('category_product.category_id', 'LIKE', '%' . $category . '%')
        ->where('products.name', 'LIKE', '%' . $fieldCamps[$i] . '%')->paginate(env('PAGINATE', 10));

      if ($result == $p || $i == 0) {
        $result = $p;
        continue;
      }
      // Ens quedem només amb els id no repetits
      $diferenIdProducts = array_diff($p->pluck('id')->toArray(), $result->pluck('id')->toArray());

      // Busquem els productes per l'id i els guardem amb una collection
      for ($j = 0; $j < count($diferenIdProducts); $j++) {
        $result->add(
          Product::where('products.id', '=', $diferenIdProducts[0])
            ->orWhere('isVisible', '=', 1)
            ->orWhere('isDeleted', '=', 0)
            ->orWhere('selled_at', '=', null)
            ->first()
        );
      }
    }
    $resultOrder = $order == 'ASC' ?  $result->sortBy('name') : $result->sortByDesc('name');
    // Instanciem  un objecte Paginator, amb els paràmetres de la collection
    return new LengthAwarePaginator($resultOrder, $result->total(), $result->perPage());
  }

  /**
   * This PHP function retrieves products from a database based on category and order specified in a
   * JSON configuration file for a landing page.
   * 
   * @return an array containing two arrays:  and .  contains the titles of the
   * categories and  contains the products that belong to each category.
   */
  public static function landingPageFilter()
  {
    $title = [];
    $p = [];
    $result = [];

    $landingPageConfigRute = base_path() . env('LANDING_PAGE_CONFIG');
    $landingPageConfig = json_decode(file_get_contents($landingPageConfigRute), true);


    if (isset($landingPageConfig['categorys'])) {
      for ($i = 0; $i < count($landingPageConfig['categorys']); $i++) {
        array_push(
          $p,
          Product::select('products.id', 'products.created_at', 'products.updated_at', 'products.name', 'products.description', 'products.price', 'products.selled_at', 'products.shop_id', 'images.url')
            ->join('category_product', 'products.id', '=', 'category_product.id')
            ->join('categories', 'category_product.category_id', '=', 'categories.id')
            ->join('product_images', 'products.id', '=', 'product_images.product_id')
            ->join('images', 'product_images.image_id', '=', 'images.id')
            ->where('categories.name', '=', $landingPageConfig['categorys'][$i]['categoryName'])
            ->where('product_images.isMain', '=', 1)
            ->where('isVisible', '=', 1)
            ->where('isDeleted', '=', 0)
            ->where('selled_at', '=', NULL)
            ->orderBy('products.name', $landingPageConfig['categorys'][$i]['orderBy'])->paginate(env('PAGINATE', 10))
        );
        array_push($title, $landingPageConfig['categorys'][$i]['title']);
      }
    }
    array_push($result, $title, $p);

    //dd($result);
    return $result;
  }

  public static function addProduct($request)
  {
    $shopId = Shop::where("user_id", Auth::id())->first()->id;

    $request->validate([
      'name' => 'required|min:5',
      'price' => 'required|min:1',
      'detail' => 'required|min:5'
    ]);

    $requestAll = $request->all();

    //Guardar Producte
    $product = new Product();
    $product->name = $requestAll['name'];
    $product->description = $requestAll['detail'];
    $product->price = $requestAll['price'] * 100;
    $product->isVisible = true;
    $product->isDeleted = false;
    $product->order = 1;
    $product->shop_id = $shopId;

    $product->save();

    //Guardar Imatges
    $imageFile = $request->file("file");

    $imageFile->store("/public/img");

    $image = new Image();
    $image->name = $requestAll['name'];
    $image->url = $imageFile->hashName();
    $image->save();

    $productImage = new ProductImage();
    $productImage->isMain = true;
    $productImage->image_id = $image->id;
    $productImage->product_id = $product->id;
    $productImage->save();

    $cont = 1;

    foreach ($request->file('otrasImagenes') as $value) {
      Log::alert("Entra");

      $imageFile = $value;

      $imageFile->store("/public/img");

      $image = new Image();
      $image->name = $requestAll['name'] . "-$cont";
      $image->url = $imageFile->hashName();
      $image->save();

      $productImage = new ProductImage();
      $productImage->isMain = false;
      $productImage->image_id = $image->id;
      $productImage->product_id = $product->id;
      $productImage->save();

      $cont++;
    }

    //Guardar categories
    CategoryProduct::addCategoryToProduct($request->input('category'), $product->id);
  }

  public static function updateProduct($request, $id)
  {
    $productExsists = Product::where("id", $id)->first();

    if ($productExsists != null) {

      $request->validate([
        'name' => 'required|min:5',
        'price' => 'required|min:1',
        'detail' => 'required|min:5'
      ]);

      $requestAll = $request->all();

      $product = $productExsists;

      if ($requestAll['name'] != null && $requestAll['name'] != $productExsists->name) {
        $product->name = $requestAll['name'];
      } else if ($requestAll['detail'] != null && $requestAll['detail'] != $productExsists->description) {
        $product->description = $requestAll['detail'];
      } else if ($requestAll['price'] != null && $requestAll['price'] != $productExsists->price) {
        $product->price = $requestAll['price'];
      }

      $product->save();

      if ($request->file("file") != null) {
        $imageFile = $request->file("file");

        $imageFile->store("/public/img");

        $image = new Image();
        $image->name = $requestAll['name'];
        $image->url = $imageFile->hashName();
        $image->save();

        $productImage = new ProductImage();
        $productImage->isMain = true;
        $productImage->image_id = $image->id;
        $productImage->product_id = $product->id;
        $productImage->save();
      }

      if ($request->file('otrasImagenes') != null) {
        $cont = 1;

        foreach ($request->file('otrasImagenes') as $value) {
          Log::alert("Entra");

          $imageFile = $value;

          $imageFile->store("/public/img");

          $image = new Image();
          $image->name = $requestAll['name'] . "-$cont";
          $image->url = $imageFile->hashName();
          $image->save();

          $productImage = new ProductImage();
          $productImage->isMain = false;
          $productImage->image_id = $image->id;
          $productImage->product_id = $product->id;
          $productImage->save();

          $cont++;
        }
      }

      CategoryProduct::updateCategoryProduct($request->input('category'), $id);
      return true;
    }
    return false;
  }
}
