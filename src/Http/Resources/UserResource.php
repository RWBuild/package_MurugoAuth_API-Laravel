<?php

namespace RwandaBuild\MurugoAuth\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'murugo_user_id' => $this->murugo_user_id,
            'murugo_user_avatar' => $this->murugo_user_avatar,
            'murugo_user_public_name' => $this->murugo_user_public_name,
            'token' => $this->token,
            'token_expires_at' => $this->token_expires_at,
            'email_verified_at' => $this->email_verified_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
