<?php

namespace App\Http\Controllers;

use App\Entities\MMobil;
use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\m_mobilCreateRequest;
use App\Http\Requests\m_mobilUpdateRequest;
use App\Repositories\MMobilRepository;
use App\Validators\MobilValidator;
use Illuminate\Support\Facades\DB;

/**
 * Class MMobilsController.
 *
 * @package namespace App\Http\Controllers;
 */
class MMobilsController extends Controller
{
    /**
     * @var MMobilRepository
     */
    protected $repository;

    /**
     * @var MobilValidator
     */
    protected $validator;

    /**
     * MMobilsController constructor.
     *
     * @param MMobilRepository $repository
     * @param MobilValidator $validator
     */
    public function __construct(MMobilRepository $repository, MobilValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $mMobils = DB::table('m_mobils')
            ->join('customers', 'm_mobils.customers_id', '=', 'customers.id')
            ->select(DB::raw('m_mobils.* , customers.nama_customer  as nama_customer'))
            ->get();

        if (request()->wantsJson()) {

           return ResponseFormatter::success($mMobils, 'Data mobil berhasil diambil');
        }

        return view('mMobils.index', compact('mMobils'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  m_mobilCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(m_mobilCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $mMobil = $this->repository->create($request->all());

            $response = [
                'message' => 'MMobil created.',
                'data'    => $mMobil->toArray(),
            ];

            if ($request->wantsJson()) {

                return ResponseFormatter::success($response, 'Data berhasil ditambahkan');
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return ResponseFormatter::error($e->getMessageBag(), 'Data gagal disimpan', 500);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mMobils = DB::table('m_mobils')
        ->where('m_mobils.id', '=' ,$id)
        ->join('customers', 'm_mobils.customers_id', '=', 'customers.id')
        ->select(DB::raw('m_mobils.* , customers.nama_customer  as nama_customer'))
        ->get();

        if (request()->wantsJson()) {

            return ResponseFormatter::success($mMobils, 'Data berhasil diambil');
        }

        return view('mMobils.show', compact('mMobil'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mMobil = $this->repository->find($id);

        return view('mMobils.edit', compact('mMobil'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  m_mobilUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(m_mobilUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $mMobil = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'MMobil updated.',
                'data'    => $mMobil->toArray(),
            ];

            if ($request->wantsJson()) {

                return ResponseFormatter::success($response, 'Data berhasil diubah');
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return responseFormatter::error($e->getMessageBag(), 'Data gagal diubah', 500);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = MMobil::where('id', $id)->first();



        if (!empty($deleted->id) && isset($deleted->id)) {
            $deleted = $this->repository->delete($id);
            if (request()->wantsJson()) {

                return ResponseFormatter::success($deleted, 'Data berhasil dihapus');
            }
        } else {
            if (request()->wantsJson()) {

                return ResponseFormatter::error(
                    null,
                    'Data customer gagal dihapus.'
                );
            }
        }

        return redirect()->back()->with('message', 'MMobil deleted.');
    }
}
