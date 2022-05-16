from flask import Flask, render_template, request, make_response, session, redirect

import sqlite3
import pickle
import base64
import os

app = Flask(__name__)
app.config['SECRET_KEY'] = os.urandom(32)
DATABASE = 'users.db'


class User(object):
    def __init__(self, username, name, email):
        self.username = username
        self.name = name
        self.email = email


def create_cookie(data):
    return base64.b64encode(pickle.dumps(User(data[0], data[1], data[2])))

@app.route('/')
def index():
    return render_template('home.html')


@app.route('/login', methods=['GET', 'POST'])
def login():
    error = None
    if request.method == 'POST':
        conn = sqlite3.connect(DATABASE)
        cursor = conn.cursor()
        username = request.form['uname']
        cursor.execute('SELECT username, name, email FROM users WHERE username=:username AND password=:pass', {'username': username, 'pass': request.form['psw']})
        result = cursor.fetchone()
        conn.close()
        if not result:
            error = 'Invalid Credentials. Please try again.'
        else:
            resp = make_response(redirect('/profile'))
            resp.set_cookie('user', create_cookie(result))
            session['logged_in'] = True
            return resp
    return render_template('login.html', error=error)


@app.route('/register', methods=['GET', 'POST'])
def register():
    if request.method == 'GET':
        return render_template('register.html')
    else:
        data = request.form.copy()
        print(data)
        conn = sqlite3.connect(DATABASE)
        cursor = conn.cursor()
        try:
            cursor.execute('INSERT INTO users(name, username, password, email) VALUES (:name, :uname, :psw, :email)', data)
            conn.commit()
        except sqlite3.IntegrityError:
            conn.close()
            return render_template('register.html', error='A user with that username already exists!')
        conn.close()
        return render_template('login.html')

@app.route('/logout')
def logout():
    resp = make_response(redirect('/home'))
    resp.set_cookie('user', expires=0)
    return resp


@app.route('/profile')
def profile():
    if 'logged_in' in session:
        user = pickle.loads(base64.b64decode(request.cookies.get('user')))
        return render_template('profile.html', data=user)
    return redirect('/login')


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=8000)

