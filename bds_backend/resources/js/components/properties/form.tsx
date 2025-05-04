import { useState } from 'react';

export default function PropertyForm({
                                         categories = [],
                                         projects = [],
                                         listingTypes = [],
                                         onSubmit,
                                         initialData = {
                                             name: '',
                                             price: '',
                                             description: '',
                                             image: null,
                                             project_id: '',
                                             category_id: '',
                                             listing_type_id: '',
                                             location_id: '',
                                         },
                                     }: {
    categories: { id: number; name: string }[];
    projects: { id: number; name: string }[];
    listingTypes: { id: number; name: string }[];
    onSubmit: (data: any) => void;
    initialData?: {
        name: string;
        price: string;
        description: string;
        image: File | null;
        project_id: string;
        category_id: string;
        listing_type_id: string;
        location_id: string;
    };
}) {
    const [formData, setFormData] = useState(initialData);

    const handleInputChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement>) => {
        const { name, value } = e.target;
        setFormData({ ...formData, [name]: value });
    };

    const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        if (e.target.files) {
            setFormData({ ...formData, image: e.target.files[0] });
        }
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        onSubmit(formData);
    };

    const handleCancel = () => {
        setFormData(initialData);
    };

    return (
        <form onSubmit={handleSubmit} className="space-y-4">
            <div>
                <label htmlFor="name" className="block text-sm font-medium text-gray-700">
                    Tên bất động sản
                </label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value={formData.name}
                    onChange={handleInputChange}
                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    required
                />
            </div>
            <div>
                <label htmlFor="price" className="block text-sm font-medium text-gray-700">
                    Giá
                </label>
                <input
                    type="number"
                    id="price"
                    name="price"
                    value={formData.price}
                    onChange={handleInputChange}
                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    required
                />
            </div>
            <div>
                <label htmlFor="description" className="block text-sm font-medium text-gray-700">
                    Mô tả
                </label>
                <textarea
                    id="description"
                    name="description"
                    value={formData.description}
                    onChange={handleInputChange}
                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                />
            </div>
            <div>
                <label htmlFor="image" className="block text-sm font-medium text-gray-700">
                    Hình ảnh
                </label>
                <input
                    type="file"
                    id="image"
                    name="image"
                    onChange={handleFileChange}
                    className="mt-1 block w-full"
                />
            </div>
            <div>
                <label htmlFor="category_id" className="block text-sm font-medium text-gray-700">
                    Danh mục
                </label>
                <select
                    id="category_id"
                    name="category_id"
                    value={formData.category_id}
                    onChange={handleInputChange}
                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    required
                >
                    <option value="">Chọn danh mục</option>
                    {categories.map((category) => (
                        <option key={category.id} value={category.id}>
                            {category.name}
                        </option>
                    ))}
                </select>
            </div>
            <div>
                <label htmlFor="listing_type_id" className="block text-sm font-medium text-gray-700">
                    Loại hình
                </label>
                <select
                    id="listing_type_id"
                    name="listing_type_id"
                    value={formData.listing_type_id}
                    onChange={handleInputChange}
                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    required
                >
                    <option value="">Chọn loại hình</option>
                    {listingTypes.map((type) => (
                        <option key={type.id} value={type.id}>
                            {type.name}
                        </option>
                    ))}
                </select>
            </div>
            <div>
                <label htmlFor="project_id" className="block text-sm font-medium text-gray-700">
                    Dự án
                </label>
                <select
                    id="project_id"
                    name="project_id"
                    value={formData.project_id}
                    onChange={handleInputChange}
                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                >
                    <option value="">Chọn dự án</option>
                    {projects.map((project) => (
                        <option key={project.id} value={project.id}>
                            {project.name}
                        </option>
                    ))}
                </select>
            </div>
            <div className="flex justify-end space-x-4">
                <button
                    type="button"
                    onClick={handleCancel}
                    className="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md"
                >
                    Hủy
                </button>
                <button
                    type="submit"
                    className="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md"
                >
                    Lưu
                </button>
            </div>
        </form>
    );
}
