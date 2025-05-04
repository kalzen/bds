import AmentiesForm from '@/components/featuresManagement/amenties';
import AttributeForm from '@/components/featuresManagement/attribute';
import ListingTypeForm from '@/components/featuresManagement/listing_type';
import PropertiesCategoryForm from '@/components/featuresManagement/properties_category';
import AppLayout from '@/layouts/app-layout';
import { Attributes, ListingType, PropertyCategory, type Amenities, type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Quản lý tiện ích',
        href: '/features/management',
    },
];

export default function FeaturesManagement({
    attribute = [],
    amenties = [],
    listing_types = [],
    properties_categories = [],
}: {
    attribute: Attributes[];
    amenties: Amenities[];
    listing_types: ListingType[];
    properties_categories: PropertyCategory[];
}) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Trang chủ" />
            <div className="flex h-full flex-col gap-4 rounded-xl p-4">
                <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2">
                    <div className="border-sidebar-border/70 dark:border-sidebar-border relative overflow-hidden rounded-xl border">
                        <AttributeForm attributes={attribute} />
                    </div>
                    <div className="border-sidebar-border/70 dark:border-sidebar-border relative overflow-hidden rounded-xl border">
                        <AmentiesForm amenities={amenties} />
                    </div>
                </div>
                <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2">
                    <div className="border-sidebar-border/70 dark:border-sidebar-border relative overflow-hidden rounded-xl border">
                        <ListingTypeForm listingTypes={listing_types} />
                    </div>
                    <div className="border-sidebar-border/70 dark:border-sidebar-border relative overflow-hidden rounded-xl border">
                        <PropertiesCategoryForm propertyCategories={properties_categories} />
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
