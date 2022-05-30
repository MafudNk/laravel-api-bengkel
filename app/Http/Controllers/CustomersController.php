<?php

namespace App\Http\Controllers;

use App\Entities\Customer;
use App\Entities\MMobil;
use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\CustomerCreateRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Repositories\CustomerRepository;
use App\Validators\CustomerValidator;
use Illuminate\Support\Facades\Auth;

/**
 * Class CustomersController.
 *
 * @package namespace App\Http\Controllers;
 */
class CustomersController extends Controller
{
    /**
     * @var CustomerRepository
     */
    protected $repository;

    /**
     * @var CustomerValidator
     */
    protected $validator;

    /**
     * CustomersController constructor.
     *
     * @param CustomerRepository $repository
     * @param CustomerValidator $validator
     */
    public function __construct(CustomerRepository $repository, CustomerValidator $validator)
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
        $customers = $this->repository->all();
            if (request()->wantsJson()) {
                return ResponseFormatter::success(
                    $customers,
                    'Data customer berhasil diambil.'
                );
            }
        return view('customers.index', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CustomerCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CustomerCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $customer = $this->repository->create($request->all());

            $response = [
                'message' => 'Customer created.',
                'data'    => $customer->toArray(),
            ];

            if ($request->wantsJson()) {
                $mobil = new MMobil;
                $mobil->nama = $request->nama_mobil;
                $mobil->customers_id = $customer->id;
                $mobil->no_chasis = $request->no_chasis;
                $mobil->no_mesin = $request->no_mesin;
                $mobil->no_pol = $request->no_pol;
                $mobil->merk_mobil = $request->merk_mobil;
                $mobil->tipe_mobil = $request->tipe_mobil;
                $mobil->save();

                if ($mobil->id) {
                    return ResponseFormatter::success($mobil, 'Data customer dan mobil berhasil ditambahkan');
                }else{
                    return ResponseFormatter::error($response, 'Data customer dan mobil gagal ditambahkan');
                }
                // return ResponseFormatter::success(
                //     $customer->toArray(),
                //     'Data customer berhasil ditambahkan.'
                // );
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return ResponseFormatter::error(
                    $e->getMessageBag(),
                    'Data customer gagal ditambahkan.'
                );
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
        $customer = $this->repository->find($id);

        if (request()->wantsJson()) {

            return ResponseFormatter::success(
                $customer,
                'Data customer berhasil diambil.'
            );
        }

        return view('customers.show', compact('customer'));
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
        $customer = $this->repository->find($id);

        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CustomerUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(CustomerUpdateRequest $request, $id)
    {
        try {

            // print_r($request->all());exit;
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $customer = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Customer updated.',
                'data'    => $customer->toArray(),
            ];

            if ($request->wantsJson()) {

                return ResponseFormatter::success(
                    $customer->toArray(),
                    'Data customer berhasil diubah.'
                );
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return ResponseFormatter::error(
                    $e->getMessageBag(),
                    'Data customer gagal diubah.'
                );
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
        
        $deleted = Customer::Where('id',$id)->first();
        if (!empty($deleted->id) && isset($deleted->id)) {
            $deleted = $this->repository->delete($id);
            if (request()->wantsJson()) {

                return ResponseFormatter::success(
                    $deleted,
                    'Data customer berhasil dihapus.'
                );
            }
        } else {
            if (request()->wantsJson()) {

                return ResponseFormatter::error(
                    null,
                    'Data customer gagal dihapus.'
                );
            }
        }


        // return redirect()->back()->with('message', 'Customer deleted.');
    }
}
