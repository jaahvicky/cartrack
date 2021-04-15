<?php

class VehicleController extends Controller
{
    public function index()
    {
        $vehicleModel = new VehicleModel("vehicles");

        $vehicles = $vehicleModel->getAll();

        return Response::sendJson(["data" => $vehicles], 200);
    }
    public function show($id)
    {
        $vehicleModel = new VehicleModel("vehicles");

        $vehicle = $vehicleModel->getById($id);
        if (!$vehicle) {
            return Response::sendJson(["message" => "Invalid details supplied", "status" => false], 404);
        }
        return Response::sendJson(["data" => $vehicle], 200);
    }
    public function store($request)
    {
        $vehicleModel = new VehicleModel("vehicles");
        $rules = [
            'name' => 'required|unique',
            'number_plate' => 'required|unique',
        ];
        $validation = Form::validate($request, $rules, $vehicleModel);
        if ($validation->hasError) {
            return Response::sendJson(["status" => false, 'errors' => $validation->errors], 400);
        }
        $vehicles = $vehicleModel->create($request);
        if (!$vehicles) {
            return Response::sendJson(["message" => "create vehicle was unsuccessful"], 400);
        }
        return Response::sendJson(["data" => $vehicles], 200);
    }
    public function update($id, $request)
    {
        $vehicleModel = new VehicleModel("vehicles");
        $rules = [
            'name' => 'required|unique',
            'number_plate' => 'required|unique',
        ];
        $vehicle = $vehicleModel->getById($id);
        if (!$vehicle) {
            return Response::sendJson(["message" => "Invalid details supplied", "status" => false], 404);
        }
        $validation = Form::validate($request, $rules, $vehicleModel, $id);
        if ($validation->hasError) {
            return Response::sendJson(["status" => false, 'errors' => $validation->errors], 400);
        }
        $vehicle = $vehicleModel->update($id, $request);

        return Response::sendJson(["data" => $vehicle], 200);
    }
    public function destroy($id)
    {
        $vehicleModel = new VehicleModel("vehicles");
        $vehicle = $vehicleModel->getById($id);
        if (!$vehicle) {
            return Response::sendJson(["message" => "Invalid details supplied", "status" => false], 404);
        }
        $isdeleted = $vehicleModel->remove($id);

        return Response::sendJson(["data" => ($isdeleted ? "deleted" : "failed to delete")], 200);
    }
}