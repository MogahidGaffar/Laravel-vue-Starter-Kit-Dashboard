<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Log;
use Spatie\Permission\Models\Role;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Cache;
class DashboardController extends Controller
{

    public function index()
{
    // Fetch all roles and prepare chart data
    $UserPerRolechartData = $this->getRolesChartData();

    // Group logs and prepare chart data
    $actionsChartData = $this->getLogsChartDataByAction();
    $modulesChartData = $this->getLogsChartDataByModule();
    $usersChartData = $this->getLogsChartDataByUser();
    $statusChartData = $this->getUsersChartDataByStatus();

    return Inertia::render('Dashboard', [
        'translations' => __('messages'),
        'UserPerRolechartData' => $UserPerRolechartData,
        'actionsChartData' => $actionsChartData,
        'modulesChartData' => $modulesChartData,
        'usersChartData' => $usersChartData,
        'statusChartData' => $statusChartData, 
        'userCount' => User::count(),
        'rolesCount' => Role::count(),
    ]);
}


    private function getRolesChartData()
    {
        return Cache::remember('roles_chart_data', 60, function () {
            $roles = Role::withCount('users')->get();
            return [
                'labels' => $roles->pluck('name'),
                'datasets' => [
                    [
                        'label' => 'Users per Role',
                        'backgroundColor' => ['#FF6384', '#36A2EB', '#FFCE56'],
                        'data' => $roles->pluck('users_count'),
                    ],
                ],
            ];
        });
    }
    
    private function getLogsChartDataByAction()
    {
        return Cache::remember('logs_by_action_chart_data', 60, function () {
            $logsByAction = Log::select('action', \DB::raw('count(*) as total'))
                ->groupBy('action')
                ->get();
            
            return [
                'labels' => $logsByAction->pluck('action'),
                'datasets' => [
                    [
                        'label' => 'Logs by Action',
                        'backgroundColor' => ['#FF6384', '#36A2EB', '#FFCE56'],
                        'data' => $logsByAction->pluck('total'),
                    ],
                ],
            ];
        });
    }
    
    private function getLogsChartDataByModule()
    {
        return Cache::remember('logs_by_module_chart_data', 60, function () {
            $logsByModule = Log::select('module_name', \DB::raw('count(*) as total'))
                ->groupBy('module_name')
                ->get();
    
            return [
                'labels' => $logsByModule->pluck('module_name'),
                'datasets' => [
                    [
                        'label' => 'Logs by Module',
                        'backgroundColor' => ['#4BC0C0', '#FF9F40', '#9966FF'],
                        'data' => $logsByModule->pluck('total'),
                    ],
                ],
            ];
        });
    }
    
    private function getLogsChartDataByUser()
    {
        return Cache::remember('logs_by_user_chart_data', 60, function () {
            $logsByUser = Log::select('by_user_id', \DB::raw('count(*) as total'))
                ->with('user:id,name')
                ->groupBy('by_user_id')
                ->get();
    
            return [
                'labels' => $logsByUser->pluck('user.name'),
                'datasets' => [
                    [
                        'label' => 'Logs by User',
                        'backgroundColor' => ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                        'data' => $logsByUser->pluck('total'),
                    ],
                ],
            ];
        });
    }
    
    private function getUsersChartDataByStatus()
    {
        return Cache::remember('users_by_status_chart_data', 60, function () {
            $usersByStatus = User::select('is_active', \DB::raw('count(*) as total'))
                ->groupBy('is_active')
                ->get();
    
            return [
                'labels' => ['Inactive', 'Active'],
                'datasets' => [
                    [
                        'label' => 'Users by Status',
                        'backgroundColor' => ['#FF6384', '#36A2EB'],
                        'data' => [
                            $usersByStatus->where('is_active', 0)->first()->total ?? 0,
                            $usersByStatus->where('is_active', 1)->first()->total ?? 0,
                        ],
                    ],
                ],
            ];
        });
    }
    
}    
