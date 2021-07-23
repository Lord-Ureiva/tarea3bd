from flask import Flask, render_template, Blueprint
from flask import jsonify
from config import config
from models import db
from flask import request

#BluePrints de los archivos
########################################
from pais import pais_bp
from usuario import usuario_bp
from precio_moneda import p_moneda_bp
from cuenta_bancaria import cuenta_bancaria_bp
from moneda import moneda_bp
from usuario_tiene_moneda import usuario_tiene_moneda_bp
from consultas import consultas_bp
########################################


def create_app(enviroment):
	app = Flask(__name__)
	
	app.register_blueprint(usuario_bp, url_prefix = '/api/usuario')
	app.register_blueprint(pais_bp, url_prefix= '/api/pais')
	app.register_blueprint(p_moneda_bp, url_prefix= '/api/precio_moneda')
	app.register_blueprint(cuenta_bancaria_bp, url_prefix = '/api/cuenta_bancaria')
	app.register_blueprint(moneda_bp, url_prefix= '/api/moneda')
	app.register_blueprint(usuario_tiene_moneda_bp, url_prefix= '/api/usuario_tiene_moneda')
	app.register_blueprint(consultas_bp, url_prefix= '/api/consultas')


	app.config['JSON_AS_ASCII'] = False
	app.config.from_object(enviroment)
	with app.app_context():
		db.init_app(app)
		db.create_all()
	return app

# Accedemos a la clase config del archivo config.py
enviroment = config['development']
app = create_app(enviroment)


if __name__ == '__main__':
	app.run(debug=True)
