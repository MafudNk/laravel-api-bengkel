<?php

namespace App\Http\Controllers;

use App\Entities\MSparepart;
use App\Entities\TPenerimaanBarang;
use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\t_penerimaan_barangCreateRequest;
use App\Http\Requests\t_penerimaan_barangUpdateRequest;
use App\Repositories\TPenerimaanBarangRepository;
use App\Validators\TPenerimaanValidator;
use Illuminate\Support\Facades\DB;

/**
 * Class TPenerimaanBarangsController.
 *
 * @package namespace App\Http\Controllers;
 */
class TPenerimaanBarangsController extends Controller
{
    /**
     * @var TPenerimaanBarangRepository
     */
    protected $repository;

    /**
     * @var TPenerimaanValidator
     */
    protected $validator;

    /**
     * TPenerimaanBarangsController constructor.
     *
     * @param TPenerimaanBarangRepository $repository
     * @param TPenerimaanValidator $validator
     */
    public function __construct(TPenerimaanBarangRepository $repository, TPenerimaanValidator $validator)
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
        $tPenerimaanBarangs = DB::table('t_penerimaan_barangs')
            ->join('m_spareparts', 't_penerimaan_barangs.m_sparepart_id', '=', 'm_spareparts.id')
            ->select(DB::raw('t_penerimaan_barangs.*, m_spareparts.nama as nama_sparepart'))
            ->get();

        if (request()->wantsJson()) {

            return ResponseFormatter::success($tPenerimaanBarangs, 'Data penerimaan barang berhasil diambil');
        }

        return view('tPenerimaanBarangs.index', compact('tPenerimaanBarangs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  t_penerimaan_barangCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(t_penerimaan_barangCreateRequest $request)
    {
        try {

            // dd($request->all());exit;
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);
            $tanggal_penerimaan = date('Y-m-d', strtotime($request->tanggal_penerimaan));
            // $tPenerimaanBarang = $this->repository->create($request->all());
            $penerimaan = new TPenerimaanBarang;
            $penerimaan->tanggal_penerimaan = $tanggal_penerimaan;
            $penerimaan->m_sparepart_id = $request->sparepart_id;
            $penerimaan->m_supplier_id = $request->supplier_id;
            $penerimaan->kode_part = $request->kode_part;
            $penerimaan->qty = $request->qty;
            $penerimaan->save();

            $response = [
                'message' => 'TPenerimaanBarang created.',
                'data'    => $penerimaan->toArray(),
            ];

            if ($request->wantsJson()) {
                

                if ($penerimaan->id) {
                    return ResponseFormatter::success($penerimaan, 'Data penerimaan berhasil ditambahkan');
                }else{
                    return ResponseFormatter::error($response, 'Data penerimaan gagal ditambahkan');
                }
            }

            return ResponseFormatter::success(request()->all());
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
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
        $tPenerimaanBarang = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $tPenerimaanBarang,
            ]);
        }

        return view('tPenerimaanBarangs.show', compact('tPenerimaanBarang'));
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
        $tPenerimaanBarang = $this->repository->find($id);

        return view('tPenerimaanBarangs.edit', compact('tPenerimaanBarang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  t_penerimaan_barangUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(t_penerimaan_barangUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $tPenerimaanBarang = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'TPenerimaanBarang updated.',
                'data'    => $tPenerimaanBarang->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
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
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'TPenerimaanBarang deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'TPenerimaanBarang deleted.');
    }
}
