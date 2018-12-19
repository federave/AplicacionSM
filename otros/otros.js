

class Xml {


  constructor() {

    this.xml="<?xml version='1.0' encoding='UTF-8'?>";



  }


    startTag(nombreTag)
    {
    this.xml += "<" + nombreTag + ">";
    }

    closeTag(nombreTag)
    {
    this.xml +="</" + nombreTag + ">";
    }

    addValue(valor)
    {
    this.xml += valor;
    }

    addTag(nombreTag,valor)
    {
    this.startTag(nombreTag);
    this.addValue(valor);
    this.closeTag(nombreTag);
    }

    getXML(){return this.xml;}

    toString(){return this.xml;}



}


function crearXml(xml)
{
    if (window.DOMParser)
    {

        parser = new DOMParser();
        xmlDoc = parser.parseFromString(xml, "text/xml");
    }
    else // Internet Explorer
    {

        xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
        xmlDoc.async = false;
        xmlDoc.loadXML(xml);
    }

    return xmlDoc;
}
