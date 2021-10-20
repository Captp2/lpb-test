## Context 🤖

A chatbot such as those proposed by Les petits bots relies on what we call a **knowledge base**. This knowledge base is composed of many intents that cover the chatbot's domain of competence.

An **intent** corresponds to a linguistic entity understandable by the chatbot.

In this project, an intent is composed of:
- a title
- a status (`published` or `draft`)
- an answer
- training sentences (allow the chatbot to understand several ways for asking the same question)

The answers and the training sentences have their own table.

## Subject 📜

Time of realization: between 2 and 3 hours.

You have at your disposal a Laravel app, including some migrations, seeds, and tests (which do not pass).

The application and its database are ready to develop an API for administrating the chatbot's intents.

1. **Using the framework, the Eloquent ORM, and the best practices**, propose an implementation to solve the tests
2. Perform the refactoring you deem relevant
3. Propose a basic UI implementation allowing us to visualize the list of intents returned by the API (optional)

## Bootstrap project 🛠

Executes the following command to bootstrap the project:

```bash
git clone https://github.com/les-petits-bots/technical-test.git
cd technical-test
composer install
```

Executes the tests:
```bash
php artisan test
```

The tests are located here: `tests/Feature/ApiTest.php`
Your code should start here: `routes/api.php`

**Good luck and enjoy! 😄**