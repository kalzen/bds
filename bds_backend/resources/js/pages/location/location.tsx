import CityForm from '@/components/Cities/City';
import DistrictIndex from '@/components/Cities/District';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, type City, District } from '@/types';
import { Head } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Vị trí',
        href: '/location',
    },
];

export default function Location({ cities, districts, filters, emptyMessage,}: {city?: City;cities: City[]; districts: District[]; filters: {search?: string; city_id?: string; }; emptyMessage?: string;}) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Trang chủ" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="grid auto-rows-min gap-4 md:grid-cols-3">
                    <div className="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border" />
                    <div className="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border" />
                    <div className="border-sidebar-border/70 dark:border-sidebar-border relative overflow-hidden rounded-xl border">
                        <CityForm cities={cities} />
                    </div>
                </div>

                <div className="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border p-4 md:min-h-min">
                    {/* 👇 Render DistrictIndex tại đây */}
                    <DistrictIndex districts={districts} cities={cities} filters={filters} emptyMessage={emptyMessage} />
                </div>
            </div>
        </AppLayout>
    );
}
