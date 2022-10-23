export interface PageInterface {
    page: {
        id: number|null,
        title: string,
        slug: string,
        content: string,
        header: string|null,
        footer: string|null
    }
}