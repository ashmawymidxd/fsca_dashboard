<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Sustainability;
use App\Models\SupportAndHelp;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Contact;

class DashboardController extends Controller
{
    public function index()
    {
        // Counts for cards
        $projectsCount = Project::count();
        $sustainabilitiesCount = Sustainability::count();
        $supportHelpsCount = SupportAndHelp::count();
        $servicesCount = Service::count();
        $serviceCategoriesCount = ServiceCategory::count();
        $contactsCount = Contact::count();

        // Monthly activity data (last 6 months)
        $monthlyLabels = [];
        $monthlyProjects = [];
        $monthlySustainabilities = [];
        $monthlySupportHelps = [];
        $monthlyServices = [];
        $monthlyServiceCategories = [];
        $monthlyContacts = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyLabels[] = $date->format('M Y');

            $monthlyProjects[] = Project::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $monthlySustainabilities[] = Sustainability::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $monthlySupportHelps[] = SupportAndHelp::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $monthlyServices[] = Service::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $monthlyServiceCategories[] = ServiceCategory::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $monthlyContacts[] = Contact::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        return view('dashboard', compact(
            'projectsCount',
            'sustainabilitiesCount',
            'supportHelpsCount',
            'servicesCount',
            'serviceCategoriesCount',
            'contactsCount',
            'monthlyLabels',
            'monthlyProjects',
            'monthlySustainabilities',
            'monthlySupportHelps',
            'monthlyServices',
            'monthlyServiceCategories',
            'monthlyContacts'
        ));
    }
}
