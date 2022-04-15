<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MKategoriPekerjaanCreateRequest;
use App\Http\Requests\MKategoriPekerjaanUpdateRequest;
use App\Repositories\MKategoriPekerjaanRepository;
use App\Validators\MKategoriPekerjaanValidator;

/**
 * Class MKategoriPekerjaansController.
 *
 * @package namespace App\Http\Controllers;
 */
class MKategoriPekerjaansController extends Controller
{
    /**
     * @var MKategoriPekerjaanRepository
     */
    protected $repository;

    /**
     * @var MKategoriPekerjaanValidator
     */
    protected $validator;

    /**
     * MKategoriPekerjaansController constructor.
     *
     * @param MKategoriPekerjaanRepository $repository
     * @param MKategoriPekerjaanValidator $validator
     */
    public function __construct(MKategoriPekerjaanRepository $repository, MKategoriPekerjaanValidator $validator)
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
        $mKategoriPekerjaans = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mKategoriPekerjaans,
            ]);
        }

        return view('mKategoriPekerjaans.index', compact('mKategoriPekerjaans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MKategoriPekerjaanCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MKategoriPekerjaanCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $mKategoriPekerjaan = $this->repository->create($request->all());

            $response = [
                'message' => 'MKategoriPekerjaan created.',
                'data'    => $mKategoriPekerjaan->toArray(),
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
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mKategoriPekerjaan = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mKategoriPekerjaan,
            ]);
        }

        return view('mKategoriPekerjaans.show', compact('mKategoriPekerjaan'));
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
        $mKategoriPekerjaan = $this->repository->find($id);

        return view('mKategoriPekerjaans.edit', compact('mKategoriPekerjaan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MKategoriPekerjaanUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MKategoriPekerjaanUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $mKategoriPekerjaan = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'MKategoriPekerjaan updated.',
                'data'    => $mKategoriPekerjaan->toArray(),
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
                'message' => 'MKategoriPekerjaan deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'MKategoriPekerjaan deleted.');
    }
}
