import { LucideIcon } from 'lucide-react';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon | null;
    isActive?: boolean;
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;

    [key: string]: unknown;
}

export interface User {
    id: number;
    full_name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    phone?: string;

    [key: string]: unknown;
}

export interface Property {
    id: number;
    user_id?: number; // Optional
    project_id?: number; // Optional
    listing_type_id?: number; // Optional
    category_id?: number; // Optional
    location_id?: number; // Optional
    name: string;
    address: string;
    description: string;
    price: number;
    amenities: PropertyAmenity[];
    attributes: {
        attribute: {
            id: number;
            name: string
        }; value: string | number }[];
    media?: {
        id: number;
        original_url: string;
    }[];
    category?: {
        name: string;
        icon_url: string;
    };
    location?: {
        address: string;
    };
}

export interface PropertyAmenity {
    amenity: Amenities;
    value: string;
}

export interface PropertyAttribute {
    attribute: Attributes;
    value: string | number;
}

export interface Provinces {
    id: number;
    name: string;
    slug: string;
    type: string;
    name_with_type: string;
    code: string;
}

export interface Project {
    id: number;
    name: string;
    investor: string;
    number_of_units: string;
    location_id: string;
    total_area: string;
    description: string;
    start_date: string;
    end_date: string;
    address: string;
    province_id: number ;
    district_id: number ;
    ward_id: number;
    location?: {
        address: string;
    };
}

export interface District {
    id: name;
    name: string;
    type: string;
    slug: string;
    name_with_type: string;
    path: string;
    path_with_type: string;
    code: string;
    parent_code: string;
}

export interface Ward {
    id: number;
    name: string;
    type: string;
    slug: string;
    name_with_type: string;
    path: string;
    path_with_type: string;
    code: string;
    parent_code: string;
}

export interface Amenity {
    id: number;
    name: string;
    description: string | null;
    icon_url: string | null;
}

export interface Attribute {
    id: number;
    name: string;
    data_type: string;
    description: string;
    icon_url: string | null;
}

export interface ListingType {
    id: number;
    name: string;
    description: string | null;
    icon_url: string | null;
}

export interface PropertyCategory {
    id: number;
    name: string;
    description: string | null;
    icon_url: string | null;
}

export interface News {
    id: number;
    title : string;
    slug: string;
    description: string;
    content : string;
    user_id: string;
    publish_date : string;
    category?: {
        name: string;
    };
    icon_url: string | null;
}

export interface NewsCategory {
    id: number;
    name: string;
    slug: string;
    description: string | null;
}
