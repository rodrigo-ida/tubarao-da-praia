<?php
/**
 * Created by PhpStorm.
 * User: andre.merlo
 * Date: 14/09/2017
 * Time: 15:13
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\OfferStoreRequest;
use App\Http\Requests\OfferUpdateRequest;
use App\Offer;
use App\Repositories\OfferRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;


class OffersController extends Controller
{

    /**
     * @var OfferRepository
     */
    private $repository;

    public function __construct(OfferRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

   

       $searchTerm = $request->get('search', null);

        $searchable = [
            'titulo', 'descricao'
        ];

        $query = Offer::withCount([
            'coupons',
            'coupons AS used_coupons' => function ($query) {
                $query->whereNotNull('validation_date');

            }
        ])
        ->orderBy('id', 'desc')
        ->where('active', '>=', 1);

       if (!is_null($searchTerm)) {
            $searchTerms = explode(' ', $searchTerm);
            foreach ($searchTerms as $term) {
                $query->where(function ($query) use ($term, $searchable) {
                    foreach ($searchable as $attribute) {
                        $query->orWhere($attribute, 'like', sprintf('%%%s%%', $term));
                    }
                });
            }
        }

    $paginator = $query->paginate()->appends('search', $searchTerm);

                return view('admin.offers.index', compact('query', 'searchTerm','paginator' ));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id) {

        $offer = Offer::with('coupons')
            ->withCount([
                'coupons AS used_coupons' => function ($query) {
                    $query->whereNotNull('validation_date');
                }
            ])
            ->findOrFail($id);
        $coupons = $offer->coupons()->with('client')->paginate(200);

        return view('admin.offers.show', compact(['offer', 'coupons']));

    }

    public function showno($id) {

        $offer = Offer::with('coupons')
            ->withCount([
                'coupons AS used_coupons' => function ($query) {
                    $query->whereNotNull('validation_date');
                }
            ])
            ->findOrFail($id);
        $coupons = $offer->coupons()->with('client')->paginate(200);

        return view('admin.offers.showno', compact(['offer', 'coupons']));

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $offer = Offer::findOrFail($id);
        return view('admin.offers.edit', compact(['offer']));
    }

    /**
     * @param OfferUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(OfferUpdateRequest $request, $id)
    {
        $offer = Offer::findOrFail($id);

        $data = $this->getInputFromRequest($request);

        $image = $this->storeImageIfExists($request);
        if ($image !== false) {
            $data['image_filename'] = $image;
        }

        $offer->fill($data);
        $offer->save();

        return back()->with('alert-success', 'Oferta salva com sucesso!');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $offer = Offer::make([
            'active' => true,
            'coupon_limit' => 1,
        ]);

        return view('admin.offers.create', compact(['offer']));
    }

    /**
     * @param OfferStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(OfferStoreRequest $request)
    {
        $data = $this->getInputFromRequest($request);

        $image = $this->storeImageIfExists($request);
        if ($image !== false) {
            $data['image_filename'] = $image;
        }

        $offer = Offer::create($data);

        return redirect()->route('admin.offers.edit', ['id' => $offer->id])
            ->with('alert-success', 'Oferta salva com sucesso!');
    }

    /**
     * Retorna os valores de entrada da requisição relevantes a entidade Offer
     * @param $request
     * @return mixed
     */
    private function getInputFromRequest($request)
    {
        //Offer fillable fields except 'image_filename'
        $fields = array_diff(Offer::getModel()->getFillable(), ['image_filename']);
        $data = $request->only($fields);
        $data['active'] = isset($data['active']);
        return $data;
    }

    /**
     * Armazena a imagem da oferta, se existir o parâmetro image na request
     * @param $request
     * @return stored image filename or false
     */
    private function storeImageIfExists($request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($image->isValid()) {
                $image->store(Offer::$images_storage_path, 'public');
                return $image->hashName();
            }
        }
        return false;
    }

}