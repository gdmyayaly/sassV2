const fs = require('fs');
const { JSDOM } = require('jsdom');

// Fonction pour extraire le texte, les styles et générer le JSON et le PHP dynamique
function extractAndGenerate(htmlContent, phpOutputPath, jsonOutputPath) {
    const dom = new JSDOM(htmlContent);
    const document = dom.window.document;

    let phpContent = "";
    const jsonData = {
        content: {
            elements: [],
            styles: {}
        }
    };

    // Fonction récursive pour parcourir tous les éléments enfants et extraire le contenu et les styles
    function processNode(node, elementIndex) {
        // Ignorer les noeuds de texte vides
        if (node.nodeType === dom.window.Node.TEXT_NODE) {
            return;
        }

        const tagName = node.tagName.toLowerCase();
        let styles = "";

        // Extraire les styles en ligne
        if (node.hasAttribute("style")) {
            const style = node.getAttribute("style");
            styles = `style="${processStyles(style, elementIndex)}"`;
        }

        // Ajouter le tag ouvert dans le fichier PHP
        phpContent += `<${tagName} ${styles}>\n`;

        // Si le noeud a du texte, le mapper en Twig
        if (node.textContent.trim() !== '') {
            const sanitizedText = sanitizeText(node.textContent.trim());
            phpContent += `{{ section.content.elements[${elementIndex}].text }}\n`;

            // Ajouter le contenu textuel au JSON
            jsonData.content.elements.push({
                tag: tagName,
                text: sanitizedText
            });
        }

        // Parcourir les enfants du noeud
        node.childNodes.forEach((childNode) => {
            processNode(childNode, jsonData.content.elements.length);
        });

        // Fermer la balise dans le fichier PHP
        phpContent += `</${tagName}>\n`;
    }

    // Fonction pour nettoyer et formater le texte pour Twig
    function sanitizeText(text) {
        return text.toLowerCase().replace(/\s+/g, '_');
    }

    // Fonction pour transformer les styles inline en Twig et ajouter au JSON
    function processStyles(styleString, elementIndex) {
        const stylePairs = styleString.split(';').map(s => s.trim()).filter(Boolean);
        let styleTwig = '';

        jsonData.content.styles[elementIndex] = {};

        stylePairs.forEach(pair => {
            const [property, value] = pair.split(':').map(s => s.trim());
            const twigProperty = property.replace(/-+/g, '_'); // Remplacer les tirets par des underscores
            styleTwig += `${property}: {{ section.content.styles[${elementIndex}]['${twigProperty}'] }}; `;
            jsonData.content.styles[elementIndex][twigProperty] = value;
        });

        return styleTwig.trim();
    }

    // Démarrer avec le body du document HTML
    document.body.childNodes.forEach((node) => {
        processNode(node, jsonData.content.elements.length);
    });

    // Écrire le contenu PHP généré dans le fichier de sortie
    fs.writeFileSync(phpOutputPath, phpContent, 'utf8');
    console.log(`PHP template generated at: ${phpOutputPath}`);

    // Écrire le contenu JSON dans le fichier de sortie
    fs.writeFileSync(jsonOutputPath, JSON.stringify(jsonData, null, 2), 'utf8');
    console.log(`JSON data generated at: ${jsonOutputPath}`);
}

// Lire le fichier HTML d'entrée
const htmlFilePath = 'input.html'; // Chemin vers ton fichier HTML d'entrée
const htmlContent = fs.readFileSync(htmlFilePath, 'utf8');

// Générer le fichier PHP et JSON
extractAndGenerate(htmlContent, 'output.php', 'output.json');
