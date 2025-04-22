import { usePage } from '@inertiajs/react';

type City = {
    id: number;
    name: string;
};

type PageProps = {
    cities: City[];
    emptyMessage?: string | null;
};

export default function Index() {
    const { cities, emptyMessage } = usePage<PageProps>().props;

    return (
        <div>
            <h1 className="text-2xl font-bold mb-4">Danh sách thành phố</h1>

            {emptyMessage ? (
                <p className="text-gray-500 italic">{emptyMessage}</p>
            ) : (
                <ul className="list-disc pl-5">
                    {cities.map(city => (
                        <li key={city.id}>{city.name}</li>
                    ))}
                </ul>
            )}
        </div>
    );
}
