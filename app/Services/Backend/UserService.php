<?php

namespace App\Services\Backend;

use App\Models\User;
use Laravel\Jetstream\Agent;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class UserService
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public  function sessions(): Collection
    {
        if (config('session.driver') !== 'database') {
            return collect();
        }

        return collect(
            DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
                ->where('user_id', $this->user->getAuthIdentifier())
                ->orderBy('last_activity', 'desc')
                ->get()
        )->map(function ($session) {
            $agent = $this->createAgent($session);

            return (object) [
                'agent' => [
                    'is_desktop' => $agent->isDesktop(),
                    'platform' => $agent->platform(),
                    'browser' => $agent->browser(),
                ],
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === request()->session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });
    }

    public function destroySessions()
    {
        DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
            ->where('user_id', $this->user->getAuthIdentifier())
            ->orderBy('last_activity', 'desc')
            ->delete();
    }

    /**
     * Create a new agent instance from the given session.
     *
     * @param  mixed  $session
     * @return \Laravel\Jetstream\Agent
     */
    protected function createAgent($session)
    {
        return tap(new Agent(), fn ($agent) => $agent->setUserAgent($session->user_agent));
    }
}
