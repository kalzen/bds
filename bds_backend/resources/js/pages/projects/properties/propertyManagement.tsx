import PropertyForm from '@/components/properties/propertyForm';
import AppLayout from '@/layouts/app-layout';
import { Property } from '@/types';
import { Head } from '@inertiajs/react';

const breadcrumbs = [
    {
        title: 'Bất động sản',
        href: '/properties',
    },
];
console.log('management');
export default function PropertyManagementPage({
    property,
    properties = [],
    categories = [],
    projects = [],
    amenities = [],
    attributes = [],
    provinces = [],
    districts = [],
    wards = [],
    listing_types = [],
    emptyMessage = 'Không có bất động sản nào.',
    auth,
}: {
    property?: Property;
    properties: Property[];
    categories: { id: number; name: string }[];
    projects: { id: number; name: string }[];
    amenities: { id: number; name: string }[];
    attributes: { id: number; name: string }[];
    provinces: { id: number; name: string; code: string }[];
    districts: { id: number; name: string; code: string; parent_code: string }[];
    wards: { id: number; name: string; code: string; parent_code: string }[];
    listing_types: { id: number; name: string }[];
    emptyMessage: string | null;
    auth: {
        user: {
            id: number;
            name: string;
        };
    };
}) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Quản lý bất động sản" />

            <div className="flex h-full flex-col gap-4 rounded-xl p-4">
                <div className="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border p-4 md:min-h-min">
                    <PropertyForm
                        property={property} // 👈 Thêm prop này
                        properties={properties}
                        categories={categories}
                        projects={projects}
                        amenities={amenities}
                        attributes={attributes}
                        provinces={provinces}
                        districts={districts}
                        wards={wards}
                        listingTypes={listing_types}
                        currentUserId={auth.user.id}
                    />
                    {properties.length === 0 && <div className="mt-4 text-center text-gray-500">{emptyMessage}</div>}
                </div>
            </div>
        </AppLayout>
    );
}
