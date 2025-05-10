import { Button } from '@/components/ui/button';
import { Property } from '@/types';
import { router } from '@inertiajs/react';

interface PropertyIndexProps {
    properties: Property[];
    onEdit: (property: Property) => void;
    onDelete: (id: number) => void;
    onCreate: () => void;
}
const handleCreate = () => {
    router.visit('/properties/create');
};

const handleEdit = (property: Property) => {
    router.visit(`/properties/${property.id}/edit`);
};

const handleDelete = (id: number) => {
    if (confirm('Bạn có chắc chắn muốn xoá bất động sản này?')) {
        router.delete(`/properties/${id}`, {
            onSuccess: () => {
                alert('Xoá bất động sản thành công!');
                window.location.reload(); // Hoặc cập nhật danh sách bất động sản
            },
        });
    }
};

// eslint-disable-next-line @typescript-eslint/no-unused-vars
export default function PropertyIndex({ properties, onEdit, onDelete, onCreate }: PropertyIndexProps) {
    console.log(properties)
    return (
        <div className="space-y-6">
            <div className="flex items-center justify-between">
                <h1 className="text-2xl font-semibold">🏘️ Property Listings</h1>
                <Button onClick={handleCreate}>+ Add Property</Button>
            </div>

            <div className="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                {properties.length > 0 ? (
                    properties.map((property) => (
                        <div key={property.id} className="rounded-2xl border bg-white p-4 shadow transition duration-200 hover:shadow-lg">
                            {property.media?.[0]?.original_url && (
                                <img src={property.media[0].original_url} alt={property.name} className="mb-3 h-48 w-full rounded-xl object-cover" />
                            )}
                            <h2 className="text-xl font-bold">Tên bất động sản: {property.name}</h2>
                            <p className="mb-2 text-gray-600">{property.address}</p>
                            <p className="mb-2 text-lg font-semibold text-green-600">
                                Giá: {new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(property.price)}
                            </p>
                            <p className="line-clamp-2 text-sm text-gray-500">
                                <strong>  Dự án: </strong> {property.project?.name}
                            </p>

                            <p className="line-clamp-2 text-sm text-gray-500">
                                <strong>  Thuộc tính: </strong> {property.attribute_display}
                            </p>

                            <p className="line-clamp-2 text-sm text-gray-500">
                                <strong>  Tiện ích: </strong> {property.amenity_display}
                            </p>

                            <p className="line-clamp-2 text-sm text-gray-500">
                                <strong>  Địa chỉ: </strong> {property.location?.address}
                            </p>
                            <p className="mt-2 text-sm text-gray-700 flex items-center gap-2">
                                <strong>Loại hình:</strong>
                                {property.listing_type?.icon_url && (
                                    <img
                                        src={property.listing_type.icon_url}
                                        alt="Icon"
                                        className="h-5 w-5 object-contain rounded border"
                                    />
                                )}
                                <span>{property.listing_type?.name ?? 'N/A'}</span>
                            </p>
                            <p className="mt-2 text-sm text-gray-700 flex items-center gap-2">
                                <strong>Danh mục:</strong>
                                {property.category?.icon_url && (
                                    <img
                                        src={property.category.icon_url}
                                        alt="Icon"
                                        className="h-5 w-5 object-contain rounded border"
                                    />
                                )}
                                <span>{property.category?.name ?? 'N/A'}</span>
                            </p>

                            <div className="mt-4 flex justify-between">
                                <Button size="sm" onClick={() => handleEdit(property)}>
                                    Edit
                                </Button>
                                <Button size="sm" variant="destructive" onClick={() => handleDelete(property.id)}>
                                    Delete
                                </Button>
                            </div>
                        </div>
                    ))
                ) : (
                    <p className="col-span-full text-center text-gray-500">🚫 No properties found.</p>
                )}
            </div>
        </div>
    );
}
