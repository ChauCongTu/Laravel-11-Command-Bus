<?php
namespace App\Handlers\Auth;

use App\Commands\Auth\ForgotPasswordCommand;
use App\Exceptions\ServerException;
use App\Http\Services\EmailService;
use Illuminate\Support\Facades\DB;

class ForgotPasswordHandler
{
    public function __construct(private EmailService $emailService)
    {}
    public function handle(ForgotPasswordCommand $command)
    {
        DB::beginTransaction();
        try {
            $this->emailService->sendMailReset($command->getEmail());
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new ServerException($th->getMessage());
        }
    }
}
