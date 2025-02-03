# Laravel Chat Package

## Introduction

The **Laravel Chat Package** is a complete real-time chat solution built on Laravel. It includes all essential chat functionalities, such as user management, message handling, attachments, reactions, and more. This package provides ready-to-use APIs, migrations, models, services, and requests to facilitate seamless integration into any Laravel application.

## Features

- **Chat Management**: Create and manage different chat types.
- **User Management**: Add, remove, and assign admin roles.
- **Messaging System**: Send, delete, and reply to messages.
- **Attachments**: Support for file sharing in chat messages.
- **Message Reactions**: Add reactions to messages.
- **Message Views**: Track message reads.
- **Chat Settings**: Manage chat-specific settings.

## Installation

### Prerequisites

- Laravel 9+
- PHP 8.0+
- MySQL or PostgreSQL

### Steps

1. Install the package via Composer:
   ```sh
   composer require your-namespace/chat-package
   ```
2. Publish the package configuration:
   ```sh
   php artisan vendor:publish --tag=chat-config
   ```
3. Run database migrations:
   ```sh
   php artisan migrate
   ```
4. Add the service provider (if not auto-discovered):
   ```php
   'providers' => [
       YourNamespace\ChatPackage\ChatServiceProvider::class,
   ];
   ```

## Usage

### API Endpoints

| Method | Endpoint                    | Description                |
| ------ | --------------------------- | -------------------------- |
| `POST` | `/api/chats`                | Create a new chat          |
| `GET`  | `/api/chats/{id}`           | Get chat details           |
| `POST` | `/api/chats/{id}/messages`  | Send a message             |
| `GET`  | `/api/chats/{id}/messages`  | Fetch chat messages        |
| `POST` | `/api/messages/{id}/react`  | React to a message         |
| `POST` | `/api/messages/{id}/attach` | Attach a file to a message |

### Example Request

#### Sending a Message

```sh
curl -X POST "https://yourapp.com/api/chats/1/messages" \
     -H "Authorization: Bearer {token}" \
     -H "Content-Type: application/json" \
     -d '{
         "message": "Hello, world!"
     }'
```

## Database Schema

This package is built on the following schema:

- **Chats**: Stores chat details
- **Chat Users**: Manages user participation
- **Chat Messages**: Stores messages
- **Chat Attachments**: Handles message file uploads
- **Chat Reactions**: Tracks message reactions
- **Chat Views**: Tracks message read status
- **Chat Settings**: Manages chat configurations

## Configuration

Modify the published `config/chat.php` file to customize settings such as message limits, file storage, and more.

## License

This package is licensed under the MIT License.

## Contributing

Feel free to submit pull requests and report issues in the GitHub repository.

## Support

For issues and feature requests, open an issue on GitHub or contact support@example.com.