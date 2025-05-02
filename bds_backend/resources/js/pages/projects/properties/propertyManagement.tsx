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

function normalizeProperty(p: any): Property {
    return {
        ...p,
        amenities: p.amenities.map((a: any) => ({
            amenity: { id: a.id, name: '' },
            value: a.value,
        })),
        attributes: p.attributes.map((attr: any) => ({
            attribute: { id: attr.id, name: '' },
            value: attr.value,
        })),
    };
}

export default function PropertyManagementPage({
    property = null, // Sửa giá trị mặc định thành null
    categories = [],
    projects = [],
    amenities = [],
    listing_types = [],
    auth, // 👈 thêm dòng này
}: {
    property?: {
        id: number;
        name: string;
        price: number;
        area: number;
        address: string;
        description: string;
        category_id: number;
        project_id: number;
        amenities: {
            id: number;
            value: string | number;
        }[];
        attributes: {
            id: number;
            value: string | number;
        }[];
    } | null; // Cho phép property là null
    categories: { id: number; name: string }[];
    projects: { id: number; name: string }[];
    amenities: { id: number; name: string }[];
    listing_types: { id: number; name: string }[];
    auth: {
        user: {
            id: number;
            name: string;
            // Thêm các trường khác nếu cần
        };
    };
}) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={property ? 'Chỉnh sửa bất động sản' : 'Tạo bất động sản mới'} />
            <div className="flex h-full flex-col gap-4 rounded-xl p-4">
                <div className="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border p-4 md:min-h-min">
                    <PropertyForm
                        properties={property ? [normalizeProperty(property)] : []}
                        categories={categories}
                        projects={projects}
                        amenities={amenities}
                        listingTypes={listing_types}
                        currentUserId={auth.user.id} // 👈 Gửi user_id
                    />
                </div>
            </div>
        </AppLayout>
    );
}
