declare namespace Domain.Page.DataTransferObjects {
export type PageData = {
id: number | null;
title: string;
slug: string;
content: string;
header: string | null;
footer: string | null;
image: any | null;
images: any | Array<any>;
user_id: number | null;
created_at: any | null;
meta: any | Domain.PageDescription.DataTransferObjects.PageDescriptionData | null;
};
}
declare namespace Domain.PageDescription.DataTransferObjects {
export type PageDescriptionData = {
id: number | null;
url: string;
type: string;
title: string | null;
h1: string | null;
model_type: string | null;
meta_description: string | null;
meta_keywords: string | null;
description: string | null;
created_at: any | null;
updated_at: any | null;
image: any | null;
images: any | Array<any>;
model_id: number | null;
};
}
