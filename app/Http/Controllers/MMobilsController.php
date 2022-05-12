<?php

namespace App\Http\Controllers;

use App\Entities\MMobil;
use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MMobilCreateRequest;
use App\Http\Requests\MMobilUpdateRequest;
use App\Repositories\MMobilRepository;
use App\Validators\MMobilValidator;

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
     * @var MMobilValidator
     */
    protected $validator;

    /**
     * MMobilsController constructor.
     *
     * @param MMobilRepository $repository
     * @param MMobilValidator $validator
     */
    public function __construct(MMobilRepository $repository, MMobilValidator $validator)
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
        $mMobils = $this->repository->all();

        if (request()->wantsJson()) {

            ResponseFormatter::success($mMobils, 'Data mobil berhasil diambil');
        }

        return view('mMobils.index', compact('mMobils'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MMobilCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MMobilCreateRequest $request)
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
        $mMobil = $this->repository->find($id);

        if (request()->wantsJson()) {

            return ResponseFormatter::success($mMobil, 'Data berhasil diambil');
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
     * @param  MMobilUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MMobilUpdateRequest $request, $id)
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
