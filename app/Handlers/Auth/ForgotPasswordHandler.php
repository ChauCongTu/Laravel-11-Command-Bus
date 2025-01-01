<?php
namespace App\Handlers\Auth;

use App\Exceptions\ServerException;
use Illuminate\Support\Facades\DB;

class ForgotPasswordHandler
{
    public function handle($command)
    {
        DB::beginTransaction();
        try {
            // Your code ở đây

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new ServerException($th->getMessage());
        }
    }
}
