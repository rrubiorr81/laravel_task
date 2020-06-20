<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $notifications = Notification::all();
            return response(['notifications' => NotificationResource::collection($notifications), 'message' => 'Retrieved successfully'], 200);
        } catch (\Exception $errorException) {
            return response('Error detected', 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();

            $validator = Validator::make($data, [
                'title' => 'required|min:5|max:255',
                'description' => 'required|min:5|max:255',
                'read' => 'between:0,1',
            ]);

            if ($validator->fails()) {
                return response(['error' => $validator->errors(), 'Validation Error']);
            }

            $data['user_id'] = $request->user()->id;

            $notification = Notification::create($data);

            return response(['notification' => new NotificationResource($notification), 'message' => 'Created successfully'], 200);
        } catch (\Exception $errorException) {
            return response('Error detected', 500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Notification $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        return response(['notification' => new NotificationResource($notification), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Notification $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        try {

            $validator = Validator::make($request->all(), [
                'title' => 'min:5|max:255',
                'description' => 'min:5|max:255',
                'read' => 'between:0,1',
            ]);

            if ($validator->fails()) {
                return response(['error' => $validator->errors(), 'Validation Error']);
            }
            $notification->update($request->all());
        } catch (\Exception $exception) {
            return response('Error detected', 500);
        }

        return response(['notification' => new NotificationResource($notification), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param Notification $notification
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Notification $notification)
    {
        try {
            $notification->delete();
            return response(['message' => 'Successfully deleted notification']);

        } catch (\Exception $errorException) {
            return response('Error detected', 500);
        }

    }
}
