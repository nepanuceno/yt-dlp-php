function validateURL(url) {
    // Primeiro, verifica se a URL está vazia
    if (!url || url.trim() === '') {
        return {
            isValid: false,
            message: 'Por favor, insira uma URL'
        };
    }

    try {
        // Tenta criar um novo objeto URL (isso vai verificar se a URL é válida)
        const urlObject = new URL(url);
        
        // Lista de domínios permitidos (você pode personalizar esta lista)
        const allowedDomains = [
            'youtube.com',
            'youtu.be',
            'vimeo.com',
            'dailymotion.com'
            // Adicione mais domínios conforme necessário
        ];

        // Verifica se o domínio está na lista de permitidos
        const isAllowedDomain = allowedDomains.some(domain => 
            urlObject.hostname.includes(domain)
        );

        if (!isAllowedDomain) {
            return {
                isValid: false,
                message: 'Por favor, insira uma URL válida de um dos serviços suportados'
            };
        }

        // Verifica se o protocolo é http ou https
        if (!urlObject.protocol.match(/^https?:$/)) {
            return {
                isValid: false,
                message: 'A URL deve começar com http:// ou https://'
            };
        }

        // Se passou por todas as validações
        return {
            isValid: true,
            message: 'URL válida'
        };
    } catch (error) {
        return {
            isValid: false,
            message: 'URL inválida. Por favor, verifique o formato'
        };
    }
}