export interface SectionModel{
    id:number;
    name:string;
    content:string;
    type:string;
    css:string;
    image:string;
    js:Array<string>;
    path:string;
    urlPreview:string;
    isClient?:boolean
}