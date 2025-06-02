Skip to content
Navigation Menu
titoRoosch
bookProject

Type / to search
Code
Issues
Pull requests
Actions
Projects
Wiki
Security
Insights
Settings
bookProject
/
README.md
in
main

Edit

Preview
Indent mode

Spaces
Indent size

4
Line wrap mode

Soft wrap
Editing README.md file contents
Selection deleted
84
85
86
87
88
89
90
91
92
93
94
95
96
97
98
99
100
101
102
103
104
105
106
107
108
109
110
111
112
113
114
115
116
117
118
119
120
121
122
123
124
125
126
127
128
129
130
131
132
133
134
135
136
137
138
139
140
141
142
143
144
145
146
147
148
149
150
151
152
153
154
155
156
157
158
159
160
161
162
163

8. Generate the Laravel application key:

    ```bash
    php artisan key:generate
    ```

9. Set proper permissions for storage:

    ```bash
    chmod -R 775 storage/
    chown -R www-data:www-data storage/
    ```

10. Clear config and cache:

    ```bash
    php artisan config:clear
    php artisan cache:clear
    ```

11. Run the database migrations:

    ```bash
    php artisan migrate
    ```

12. Exit the container:

    ```bash
    exit
    ```

13. Install and build the frontend dependencies:

    ```bash
    npm install
    npm run dev
    ```

---

## Running Tests

### Backend (PHP - Pest)

1. Access the application container:

    ```bash
    docker-compose exec web bash
    ```

2. Prepare the testing database:

    ```bash
    php artisan config:clear --env=testing
    php artisan migrate:fresh --seed --env=testing
    ```

3. Exit the container:

    ```bash
    exit
    ```

4. Run backend tests:

    ```bash
    docker-compose run --rm web vendor/bin/pest
    ```

---
 ### Frontend (Vue - Vitest)

1. Run frontend tests with:


    ```bash
    npx vitest
    ```