
# STK Push Project using PHP

This project demonstrates how to integrate the Safaricom M-Pesa Daraja API to perform STK Push payments. It enables initiating payments through the M-Pesa API using PHP. The application includes local development with XAMPP or online deployment with Heroku, making it versatile for both testing and live deployment.

## Prerequisites:
You can use either **XAMPP** for local development or **Heroku** for online deployment. This guide will explain both options.


## Using XAMPP (Local Development)

### Why Use XAMPP?
[XAMPP](https://www.apachefriends.org/index.html) is a free, open-source platform that provides an easy-to-use local server environment for PHP and MySQL development. It's lightweight, fast to set up, and doesn't require you to verify your application like cloud services such as Heroku.

### Steps to Use XAMPP:
1. Install XAMPP from [Apache Friends](https://www.apachefriends.org/index.html).
2. Extract the project folder into the `htdocs` directory in your XAMPP installation folder (usually `C:/xampp/htdocs`).
3. Open the XAMPP Control Panel and start the **Apache server**.
4. Open your browser and navigate to:  
   `http://localhost/<your_project_folder>`  
   where `<your_project_folder>` is the folder you placed the project in.

---

## Using Heroku (Online Deployment)

### Why Use Heroku?
[Heroku](https://www.heroku.com/) is a cloud platform that makes it easy to deploy and run web applications without worrying about server management. If you want your STK Push project to be publicly accessible, Heroku is a great choice. However, it requires email verification for deployment.

### Steps to Deploy on Heroku:
1. Create a free account on [Heroku](https://signup.heroku.com/).
2. Install the [Heroku CLI](https://devcenter.heroku.com/articles/heroku-cli).
3. Log in to your Heroku account via terminal:
    ```bash
    heroku login
    ```
4. Create a new Heroku app:
    ```bash
    heroku create <your-app-name>
    ```
5. Push your project to Heroku:
    ```bash
    git push heroku main
    ```
6. Open the app in your browser:
    ```bash
    heroku open
    ```

---

## Configuration

Before you can use the STK Push feature, you'll need to configure the necessary parameters, such as your **M-Pesa Consumer Key**, **Consumer Secret**, **Shortcode**, **Passkey**, and **Callback URL**.

These credentials are available on the [Safaricom Developer Portal](https://developer.safaricom.co.ke/daraja/apis/post/safaricom-safaricom).

### Update the following details in the code:

- **Consumer Key**: Your M-Pesa API key.
- **Consumer Secret**: Your M-Pesa API secret.
- **Shortcode**: Your Business Shortcode.
- **Passkey**: Your Paybill passkey.
- **Callback URL**: The URL to which M-Pesa will send payment confirmation.

You can store these details in a configuration file, or directly in the PHP code for tes
