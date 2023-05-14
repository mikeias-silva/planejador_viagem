## Roteirizador 
Este projeto é uma aplicação em Laravel que utiliza a API do Google Directions para fornecer rotas, tempo de viagem e distância

### Requisitos
* PHP 8.1
* Composer instalado
* Banco de dados PostgreSQL

### Instalação
1. Clone o repositório do projeto:
 ```console 
    git clone https://github.com/mikeias-silva/planejador_viagem.git 
 ``` 
2. Instale as dependências do Laravel usando o Composer:
```
    cd planejador_viagem
    composer install 
 ```

3. Consigure o arquivo '.env' com as infomrações do banco de dados e outras configurações relevantes como a chave da api google directions:
 ```console
    cp .env.example .env
```

4. Insira no arquivo .env as informações da sua chave da api na tag:
```console
    // restante do arquivo .env
    
    API_GOOGLE_KEY=(insira sua chave da api aqui)
```

5. Execute as migrations do banco de dados:
    ```console
        php artisan migrate
    ```
   
6. Gere a chave de criptografia do Laravel

    ```console
        php artisan key:migrate
    ```

7. Instalar dependências de front-end
    ```console
        npm install
    ```
8. Agora, precisa compilar as dependencias de front-end com vite com o comando
    ```console
        npm run build
    ```

7. Inicie o servidor local:
    ```console
        php artisan serve
    ```
### Uso
* Acesse a aplicação no seu navegador em http://localhost:8000
* Acesse no menu **Nova Rota**;
* Preencha o formulário com as informações de partida e destino no mapa;
* Ao finalizar de preencher o fomulário, já estará disponível o tempo e distância da rota;

### Contato

**Nome:** Mikeias Silva

**E-mail:** mikeias26@gmail.com

**Telefone:** 42 9 9991-9395

Sinta-se à vontade para me contatar

