export interface AboutV1Model{
    titre:{
        text:string,
        couleur:string,
    },
    autreText:Array<{
        text:string,
        couleur:string,
        avecMarquage:boolean
    }>
    boutton:{
        text:string,
        couleur:string,
        couleurSurvol:string,
        lienDeRedirection:string,
    }
    sectionText1:{
        couleurDeFond:string,
        titre :{
            text:string,
            couleur:string
        },
        description :{
            text:string,
            couleur:string
        }
    }
    sectionImage1:{
        lienImage:string
    },
    sectionImage2:{
        lienImage:string
    },
    sectionText2:{
        couleurDeFond:string,
        titre :{
            text:string,
            couleur:string
        },
        description :{
            text:string,
            couleur:string
        }
    }
}