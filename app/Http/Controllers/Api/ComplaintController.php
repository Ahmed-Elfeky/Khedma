<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ComplaintRequest;
use App\Http\Resources\ComplaintResource;
use App\Models\Complaint;

class ComplaintController extends Controller
{
    public function store(ComplaintRequest $request)
    {
        $data = $request->validated();
        $complaint  = Complaint::create($data);
        return ApiResponse::SendResponse(201, 'شكرك على تواصلك معنا، تم إرسال المقترح بنجاح', new ComplaintResource($complaint));
    }
}
