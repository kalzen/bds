import { NavFooter } from '@/components/nav-footer';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/react';
import { BookOpen, Folder, LayoutGrid } from 'lucide-react';
import AppLogo from './app-logo';

const mainNavItems: NavItem[] = [
    {
        title: 'Trang chủ',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'Quản lý bất động sản',
        href: '/properties',
        icon: LayoutGrid,
    },
    {
        title: 'Quản lý dự án',
        href: '/projects',
        icon: LayoutGrid,
    },
    {
        title: 'Quản lý danh sách bài viết',
        href: '/properties',
        icon: LayoutGrid,
    },
    {
        title: 'Quản lý danh sách dự án',
        href: '/properties',
        icon: LayoutGrid,
    },
    {
        title: 'Quản lý hạng mục dự án',
        href: '/properties',
        icon: LayoutGrid,
    },
    {
        title: 'Quản lý tiện ích bất động sản',
        href: '/features/management',
        icon: LayoutGrid,
    },
    {
        title: 'Quản lý vị trí bất động sản',
        href: '/properties',
        icon: LayoutGrid,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Repository',
        href: 'https://github.com/laravel/react-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits',
        icon: BookOpen,
    },
];

export function AppSidebar() {
    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href="/dashboard" prefetch>
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavFooter items={footerNavItems} className="mt-auto" />
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
