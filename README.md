# API Articles - Documentation

Une API REST simple construite avec Laravel pour la gestion d'articles.

## 📋 Table des matières

- [Installation](#installation)
- [Configuration](#configuration)
- [Authentification](#authentification)
- [Endpoints](#endpoints)
- [Exemples JavaScript](#exemples-javascript)
- [Codes de réponse](#codes-de-réponse)
- [Structure des données](#structure-des-données)
- [Tests](#tests)

## 🚀 Installation

```bash
# Cloner le projet
git clone <url-du-repo>
cd article-api

# Installer les dépendances
composer install
npm install

# Copier le fichier d'environnement
cp .env.example .env

# Générer la clé d'application
php artisan key:generate

# Configurer la base de données dans .env
# Puis migrer
php artisan migrate

# (Optionnel) Générer des données de test
php artisan db:seed
```

## ⚙️ Configuration

### Base de données
Configurez votre base de données dans le fichier `.env` :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=article_api
DB_USERNAME=root
DB_PASSWORD=
```

### Serveur de développement
```bash
php artisan serve
```
L'API sera accessible sur `http://localhost:8000/api`

## 🔐 Authentification

Cette API utilise Laravel Sanctum pour l'authentification. Pour les endpoints protégés, incluez le token dans l'en-tête :

```javascript
headers: {
    'Authorization': 'Bearer your-token-here',
    'Content-Type': 'application/json'
}
```

## 📚 Endpoints

### Base URL
```
http://localhost:8000/api
```

| Méthode | Endpoint | Description |
|---------|----------|-------------|
| GET | `/article` | Récupérer tous les articles |
| GET | `/article/{id}` | Récupérer un article spécifique |
| POST | `/article` | Créer un nouvel article |
| PUT | `/article/{id}` | Mettre à jour un article |
| DELETE | `/article/{id}` | Supprimer un article |

## 💻 Exemples JavaScript

### 1. Récupérer tous les articles

```javascript
// Avec fetch()
async function getAllArticles() {
    try {
        const response = await fetch('http://localhost:8000/api/article');
        const data = await response.json();
        
        if (data.success) {
            console.log('Articles récupérés :', data.articles);
            return data.articles;
        }
    } catch (error) {
        console.error('Erreur :', error);
    }
}

// Avec axios
import axios from 'axios';

async function getAllArticlesAxios() {
    try {
        const response = await axios.get('http://localhost:8000/api/article');
        console.log('Articles :', response.data.articles);
        return response.data.articles;
    } catch (error) {
        console.error('Erreur :', error.response.data);
    }
}
```

### 2. Récupérer un article spécifique

```javascript
async function getArticle(id) {
    try {
        const response = await fetch(`http://localhost:8000/api/article/${id}`);
        const data = await response.json();
        
        if (data.success) {
            console.log('Article trouvé :', data.article);
            return data.article;
        }
    } catch (error) {
        console.error('Erreur :', error);
    }
}

// Exemple d'utilisation
getArticle(1);
```

### 3. Créer un nouvel article

```javascript
async function createArticle(articleData) {
    try {
        const response = await fetch('http://localhost:8000/api/article', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                // 'Authorization': 'Bearer your-token' // Si authentification requise
            },
            body: JSON.stringify(articleData)
        });
        
        const data = await response.json();
        
        if (data.success) {
            console.log('Article créé :', data.article);
            return data.article;
        }
    } catch (error) {
        console.error('Erreur :', error);
    }
}

// Exemple d'utilisation
const newArticle = {
    title: "Mon Premier Article",
    content: "Contenu de l'article...",
    published: true
};

createArticle(newArticle);
```

### 4. Mettre à jour un article

```javascript
async function updateArticle(id, articleData) {
    try {
        const response = await fetch(`http://localhost:8000/api/article/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(articleData)
        });
        
        const data = await response.json();
        
        if (data.success) {
            console.log('Article mis à jour :', data.article);
            return data.article;
        }
    } catch (error) {
        console.error('Erreur :', error);
    }
}

// Exemple d'utilisation
const updatedData = {
    title: "Titre Modifié",
    content: "Nouveau contenu...",
    published: false
};

updateArticle(1, updatedData);
```

### 5. Supprimer un article

```javascript
async function deleteArticle(id) {
    try {
        const response = await fetch(`http://localhost:8000/api/article/${id}`, {
            method: 'DELETE'
        });
        
        const data = await response.json();
        
        if (data.success) {
            console.log('Article supprimé avec succès');
            return true;
        }
    } catch (error) {
        console.error('Erreur :', error);
        return false;
    }
}

// Exemple d'utilisation
deleteArticle(1);
```

### 6. Classe utilitaire complète

```javascript
class ArticleAPI {
    constructor(baseURL = 'http://localhost:8000/api') {
        this.baseURL = baseURL;
        this.token = null;
    }
    
    setAuthToken(token) {
        this.token = token;
    }
    
    getHeaders() {
        const headers = {
            'Content-Type': 'application/json'
        };
        
        if (this.token) {
            headers['Authorization'] = `Bearer ${this.token}`;
        }
        
        return headers;
    }
    
    async request(endpoint, options = {}) {
        try {
            const response = await fetch(`${this.baseURL}${endpoint}`, {
                headers: this.getHeaders(),
                ...options
            });
            
            return await response.json();
        } catch (error) {
            console.error('Erreur API :', error);
            throw error;
        }
    }
    
    // Récupérer tous les articles
    async getAll() {
        return await this.request('/article');
    }
    
    // Récupérer un article
    async getById(id) {
        return await this.request(`/article/${id}`);
    }
    
    // Créer un article
    async create(data) {
        return await this.request('/article', {
            method: 'POST',
            body: JSON.stringify(data)
        });
    }
    
    // Mettre à jour un article
    async update(id, data) {
        return await this.request(`/article/${id}`, {
            method: 'PUT',
            body: JSON.stringify(data)
        });
    }
    
    // Supprimer un article
    async delete(id) {
        return await this.request(`/article/${id}`, {
            method: 'DELETE'
        });
    }
}

// Utilisation de la classe
const api = new ArticleAPI();

// Exemple d'utilisation complète
async function example() {
    // Créer un article
    const newArticle = await api.create({
        title: "Test Article",
        content: "Contenu de test",
        published: true
    });
    
    // Récupérer tous les articles
    const articles = await api.getAll();
    console.log('Tous les articles :', articles);
    
    // Mettre à jour l'article
    const updated = await api.update(newArticle.article.id, {
        title: "Titre mis à jour",
        content: "Contenu mis à jour",
        published: false
    });
    
    // Supprimer l'article
    await api.delete(newArticle.article.id);
}
```

## 📊 Codes de réponse

| Code | Description |
|------|-------------|
| 200 | Succès |
| 201 | Créé avec succès |
| 400 | Requête invalide |
| 404 | Ressource non trouvée |
| 422 | Erreur de validation |
| 500 | Erreur serveur |
## 📋 Structure des données

### Article

```json
{
    "id": 1,
    "title": "Titre de l'article",
    "content": "Contenu de l'article...",
    "published": true,
    "created_at": "2025-07-29T15:30:00.000000Z",
    "updated_at": "2025-07-29T15:30:00.000000Z"
}
```

### Réponse API Standard

```json
{
    "success": true,
    "message": "Message de succès",
    "article": {
        // Objet article
    }
}
```

### Réponse Liste

```json
{
    "success": true,
    "articles": [
        // Array d'articles
    ]
}
```

### Réponse d'erreur

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "title": [
            "The title field is required."
        ],
        "content": [
            "The content field is required."
        ]
    }
}
```

## 🧪 Tests

### Test avec curl

```bash
# Récupérer tous les articles
curl -X GET http://localhost:8000/api/article

# Créer un article
curl -X POST http://localhost:8000/api/article \
  -H "Content-Type: application/json" \
  -d '{"title":"Test Article","content":"Test content","published":true}'

# Récupérer un article spécifique
curl -X GET http://localhost:8000/api/article/1

# Mettre à jour un article
curl -X PUT http://localhost:8000/api/article/1 \
  -H "Content-Type: application/json" \
  -d '{"title":"Updated Title","content":"Updated content","published":false}'

# Supprimer un article
curl -X DELETE http://localhost:8000/api/article/1
```

### Test avec JavaScript (Browser Console)

```javascript
// Copiez-collez ce code dans la console du navigateur pour tester
(async () => {
    const baseURL = 'http://localhost:8000/api';
    
    try {
        // Test création
        const createResponse = await fetch(`${baseURL}/article`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                title: 'Article de test',
                content: 'Contenu de test',
                published: true
            })
        });
        const created = await createResponse.json();
        console.log('Créé :', created);
        
        // Test récupération
        const getResponse = await fetch(`${baseURL}/article`);
        const articles = await getResponse.json();
        console.log('Articles :', articles);
        
    } catch (error) {
        console.error('Erreur de test :', error);
    }
})();
```

## 🔧 Validation des données

### Champs requis pour la création/modification

- **title** : string, requis, maximum 255 caractères
- **content** : text, requis
- **published** : boolean, optionnel (défaut: false)

### Exemple de données valides

```javascript
const validArticle = {
    title: "Mon Article",
    content: "Contenu détaillé de l'article avec toutes les informations nécessaires.",
    published: true
};
```

## 🚨 Notes importantes

1. **CORS** : Assurez-vous que les CORS sont configurés pour vos domaines clients
2. **Sécurité** : En production, utilisez HTTPS et implémentez l'authentification
3. **Rate Limiting** : Considérez l'ajout de rate limiting pour éviter les abus
4. **Validation** : Tous les champs sont validés côté serveur

## 📞 Support

Pour toute question ou problème, veuillez ouvrir une issue dans le repository du projet.

---

*Documentation générée pour l'API Articles Laravel*