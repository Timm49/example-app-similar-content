export interface Article {
    id: number;
    title: string;
    slug: string;
    content: string;
    author: string;
    category: string;
    keywords: string[];
    featured_image?: string;
    excerpt?: string;
    status: string;
    published_at: string;
    created_at: string;
    updated_at: string;
}

export interface PageProps {
    auth: {
        user: {
            id: number;
            name: string;
            email: string;
        } | null;
    };
    [key: string]: any;
}
