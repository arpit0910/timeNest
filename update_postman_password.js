const fs = require('fs');
const path = require('path');

const collectionPath = path.join(__dirname, 'docs/postman/TimeNest.postman_collection.json');
let collection = JSON.parse(fs.readFileSync(collectionPath, 'utf8'));

// Find Auth folder
const authFolder = collection.item.find(i => i.name === 'Auth');

if (authFolder) {
    // Add Password folder if it doesn't exist
    let passwordFolder = authFolder.item.find(i => i.name === 'Password');
    if (!passwordFolder) {
        passwordFolder = {
            name: 'Password',
            item: []
        };
        authFolder.item.push(passwordFolder);
    }

    // Check if Forgot Password already exists
    if (!passwordFolder.item.find(i => i.name === 'Forgot Password')) {
        passwordFolder.item.push({
            name: 'Forgot Password',
            request: {
                method: 'POST',
                header: [
                    { key: 'Accept', value: 'application/json' },
                    { key: 'Content-Type', value: 'application/json' }
                ],
                body: {
                    mode: 'raw',
                    raw: JSON.stringify({ email: "user@example.com" }, null, 4),
                    options: { raw: { language: 'json' } }
                },
                url: {
                    raw: '{{base_url}}/auth/forgot-password',
                    host: ['{{base_url}}'],
                    path: ['auth', 'forgot-password']
                }
            }
        });
    }

    if (!passwordFolder.item.find(i => i.name === 'Reset Password')) {
        passwordFolder.item.push({
            name: 'Reset Password',
            request: {
                method: 'POST',
                header: [
                    { key: 'Accept', value: 'application/json' },
                    { key: 'Content-Type', value: 'application/json' }
                ],
                body: {
                    mode: 'raw',
                    raw: JSON.stringify({
                        email: "user@example.com",
                        token: "<64-char-token-from-email>",
                        password: "NewPassword123!",
                        password_confirmation: "NewPassword123!"
                    }, null, 4),
                    options: { raw: { language: 'json' } }
                },
                url: {
                    raw: '{{base_url}}/auth/reset-password',
                    host: ['{{base_url}}'],
                    path: ['auth', 'reset-password']
                }
            }
        });
    }
}

fs.writeFileSync(collectionPath, JSON.stringify(collection, null, 4));
console.log('Postman collection updated successfully.');
