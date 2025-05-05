import AmentiesForm from '@/components/featuresManagement/amenties';
import AttributeForm from '@/components/featuresManagement/attribute';
import ListingTypeForm from '@/components/featuresManagement/listing_type';
import PropertiesCategoryForm from '@/components/featuresManagement/properties_category';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import AppLayout from '@/layouts/app-layout';
import { Attributes, ListingType, PropertyCategory, type Amenities, type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Quản lý tiện ích',
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
            <Head title="Quản lý tính năng" />
            <div className="p-4">
                <Tabs defaultValue="attributes" className="w-full">
                    <TabsList className="grid w-full grid-cols-4">
                        <TabsTrigger value="attributes">Thuộc tính</TabsTrigger>
                        <TabsTrigger value="amenities">Tiện ích</TabsTrigger>
                        <TabsTrigger value="listingTypes">Loại đăng tin</TabsTrigger>
                        <TabsTrigger value="propertyCategories">Loại BĐS</TabsTrigger>
                    </TabsList>

                    <TabsContent value="attributes">
                        <div className="mt-4 rounded-xl border p-4">
                            <AttributeForm attributes={attribute} />
                        </div>
                    </TabsContent>

                    <TabsContent value="amenities">
                        <div className="mt-4 rounded-xl border p-4">
                            <AmentiesForm amenities={amenties} />
                        </div>
                    </TabsContent>

                    <TabsContent value="listingTypes">
                        <div className="mt-4 rounded-xl border p-4">
                            <ListingTypeForm listingTypes={listing_types} />
                        </div>
                    </TabsContent>

                    <TabsContent value="propertyCategories">
                        <div className="mt-4 rounded-xl border p-4">
                            <PropertiesCategoryForm propertyCategories={properties_categories} />
                        </div>
                    </TabsContent>
                </Tabs>
            </div>
        </AppLayout>
    );
}
