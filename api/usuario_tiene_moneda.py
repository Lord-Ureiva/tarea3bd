from models import Usuario_tiene_moneda
from flask import render_template, Blueprint
from flask import jsonify
from flask import request

usuario_tiene_moneda_bp = Blueprint('usuario_tiene_moneda_bp', __name__)


@usuario_tiene_moneda_bp.route('/', methods=['GET'])
def get_usuario_tiene_moneda_all():
	usuarios_tiene_monedas = [ usuario_tiene_moneda.json() for usuario_tiene_moneda in Usuario_tiene_moneda.query.all() ]
	return jsonify({'usuarios_tiene_monedas': usuarios_tiene_monedas} )
	#return render_template('usuario_tiene_moneda.html', data = usuarios_tiene_monedas)

@usuario_tiene_moneda_bp.route('/<id_usuario>/<id_moneda>', methods = ['GET'])
def get_usuario_tiene_moneda(id_usuario,id_moneda):
	usuario_moneda = Usuario_tiene_moneda.query.filter_by(id_usuario=id_usuario,id_moneda=id_moneda).first()
	if usuario_moneda is None:
		return jsonify({'mensaje': 'El usuario o moneda no existe'}), 404

	return jsonify({'usuario_moneda': usuario_moneda.json() })

@usuario_tiene_moneda_bp.route('/', methods=['POST'])
def create_usuario_tiene_moneda():
	json = request.get_json(force=True)

	if json.get('id_moneda') is None or json.get('balance') is None:
		return jsonify({'mensaje': 'El formato está mal'}), 400

	usuario_tiene_moneda = Usuario_tiene_moneda.create(json['id_usuario'],json['id_moneda'], json['balance'])
	if usuario_tiene_moneda == False:
		return jsonify({'mensaje': 'Uno de los valores No Existe'}), 400
	return jsonify({'usuario_tiene_moneda': usuario_tiene_moneda.json() })

@usuario_tiene_moneda_bp.route('/<id_usuario>/<id_moneda>', methods=['PUT'])  
def edit_usuario_tiene_moneda(id_usuario,id_moneda):
	usuario_moneda = Usuario_tiene_moneda.query.filter_by(id_usuario=id_usuario,id_moneda=id_moneda).first()
	
	if usuario_moneda is None:
		return jsonify({'mensaje': 'Moneda no existe'}), 404

	json = request.get_json(force=True)
	if json.get("balance") is None:
		return jsonify({'message': 'Bad request'}), 400


	usuario_moneda.balance = json['balance']

	usuario_moneda.update()

	return jsonify({'usuario_tiene_moneda': usuario_moneda.json() })

@usuario_tiene_moneda_bp.route('/<id_usuario>/<id_moneda>', methods=['DELETE'])
def delete_usuario_tiene_moneda(id_usuario,id_moneda):
	usuario_moneda = Usuario_tiene_moneda.query.filter_by(id_usuario=id_usuario,id_moneda=id_moneda).first()
	if usuario_moneda is None:
		return jsonify({'mensaje': 'Moneda no existe'}), 404

	usuario_moneda.delete()

	return jsonify({'usuario_tiene_moneda': usuario_moneda.json() })