<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Diary;
use App\Entity\Task;
use App\Entity\Thread;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/admin.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Pinator');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            MenuItem::linkToCrud('Users', 'fa fa-home', User::class),
            MenuItem::linkToCrud('Tasks', 'fa fa-home', Task::class),
            MenuItem::linkToCrud('Diaries', 'fa fa-home', Diary::class),
            MenuItem::linkToCrud('Categories', 'fa fa-home', Category::class),
            MenuItem::linkToCrud('Threads', 'fa fa-home', Thread::class),
        ];
    }
}
