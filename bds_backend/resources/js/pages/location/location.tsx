import CityForm from '@/components/Cities/City';
import DistrictIndex from '@/components/Cities/District';
import WardForm from '@/components/Cities/Ward';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, type City, District, Ward } from '@/types';
import { Head } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Vị trí',
        href: '/location',
    },
];

export default function Location({
                                     cities = [],
                                     districts = [],
                                     wards = [],
                                     filters,
                                     emptyMessage,
                                 }: {
    city?: City;
    cities: City[];
    district?: District;
    wards?: Ward[];
    districts: District[];
    filters: { search?: string; city_id?: string; district_id?: string };
    emptyMessage?: string;
}) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Trang chủ" />
            <div className="flex h-full flex-col gap-4 rounded-xl p-4">
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:grid-cols-3">
                    <div className="border-sidebar-border/70 dark:border-sidebar-border relative overflow-hidden rounded-xl border">
                        <DistrictIndex districts={districts} cities={cities} filters={filters} emptyMessage={emptyMessage} />
                    </div>
                    <div className="border-sidebar-border/70 dark:border-sidebar-border relative overflow-hidden rounded-xl border">
                        <CityForm cities={cities} />
                    </div>
                    <div className="border-sidebar-border/70 dark:border-sidebar-border relative overflow-hidden rounded-xl border">
                        {/* Nếu cần thêm nội dung gì cho khu vực này thì thêm vào */}
                        <WardForm wards={wards}  districts={districts} filters={filters} emptyMessage={emptyMessage} />
                    </div>
                </div>

                <div className="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border p-4 md:min-h-min">
                    {/* 👇 Render DistrictIndex tại đây */}
                </div>
            </div>
        </AppLayout>
    );
}
