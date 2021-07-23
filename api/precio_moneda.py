from models import Precio_moneda
from flask import render_template, Blueprint
from flask import jsonify
from flask import request
from datetime import datetime
from flask import app
import sys 
p_moneda_bp = Blueprint('p_moneda_bp', __name__)


@p_moneda_bp.route('/', methods=['GET'])
def get_precio_moneda_all():
	precio_monedas = [ precio_moneda.json() for precio_moneda in Precio_moneda.query.all() ]
	return jsonify({'precio_moneda': precio_monedas} )
	#return render_template('precio_moneda.html', data = precio_monedas)

@p_moneda_bp.route('/<id_moneda>/<fecha>', methods = ['GET'])
def get_precio_moneda(id_moneda,fecha):
	p_moneda = Precio_moneda.query.filter_by(id_moneda=id_moneda,fecha=fecha).first()
	if p_moneda is None:
		return jsonify({'mensaje': 'Cuenta bancaria no existe'}), 404

	return jsonify({'p_moneda': p_moneda.json() })


@p_moneda_bp.route('/', methods=['POST'])
def create_precio_moneda():
	json = request.get_json(force=True)

	if json.get('id_moneda') is None or json.get('valor') is None:
		return jsonify({'mensaje': 'El formato está mal'}), 400

	precio_moneda = Precio_moneda.create(json['id_moneda'],json['valor'])
	if precio_moneda == False:
			return jsonify({'mensaje': 'Uno de los valores No Existe'}), 400

	return jsonify({'precio_moneda':precio_moneda.json()})


@p_moneda_bp.route('/<id_moneda>/<fecha>', methods=['PUT'])
def edit_precio_moneda(id_moneda,fecha):
	precio_moneda = Precio_moneda.query.filter_by(id_moneda=id_moneda,fecha=fecha).first()
	if precio_moneda is None:
		return jsonify({'mensaje': 'Moneda no existe'}), 404

	json = request.get_json(force=True)
	if json.get('valor') is None:
		return jsonify({'message': 'Bad request'}), 400

	precio_moneda.valor = json['valor']

	precio_moneda.update()

	return jsonify({'precio_moneda': precio_moneda.json() })

@p_moneda_bp.route('/<id_moneda>/<fecha>', methods=['DELETE'])
def delete_precio_moneda(id_moneda, fecha):

	precio_moneda = Precio_moneda.query.filter_by(id_moneda=id_moneda,fecha=fecha).first()
	if precio_moneda is None:
		return jsonify({'mensaje': 'Moneda no existe'}), 404

	precio_moneda.delete()

	return jsonify({'precio_moneda': precio_moneda.json() })