<?php

namespace App\Services\Projects;

use App\Models\Heartbeat;
use App\Models\Incident;
use App\Models\Monitor;
use App\Models\MonitorPermission;
use App\Models\MonitorRegion;
use App\Models\MonitorTlsInformation;
use App\Models\NotificationSentHistory;
use App\Models\Project;
use DB;
use Exception;

class DeleteProjectService
{
    public function handle(Project $project)
    {
        DB::beginTransaction();
        try {
            $monitorIds = $project->monitors->pluck('id');

            MonitorPermission::whereIn('monitor_id', $monitorIds)->delete();

            Incident::whereIn('monitor_id', $monitorIds)->delete();

            Heartbeat::whereIn('monitor_id', $monitorIds)->delete();

            MonitorRegion::whereIn('monitor_id', $monitorIds)->delete();

            MonitorTlsInformation::whereIn('monitor_id', $monitorIds)->delete();

            DB::table('monitor_notifications')->whereIn('monitor_id', $monitorIds)->delete();

            NotificationSentHistory::whereIn('monitor_id', $monitorIds)->delete();

            DB::table('monitor_status_pages')->whereIn('monitor_id', $monitorIds)->delete();

            $project->monitors()->detach();

            Monitor::whereIn('id', $monitorIds)->delete();

            $project->users()->detach();

            $project->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }
}
