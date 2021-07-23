from models import Moneda
from flask import Blueprint
from flask import jsonify
from flask import request

moneda_bp = Blueprint('moneda_bp', __name__)

@moneda_bp.route('/', methods=['GET'])
def get_monedas():
	monedas = [ moneda.json() for moneda in Moneda.query.all() ]
	return jsonify({'monedas': monedas})
   #render_template('moneda.html', data = monedas)

@moneda_bp.route('/<id_moneda>', methods = ['GET'])
def get_moneda(id_moneda):
	moneda = Moneda.query.filter_by(id=id_moneda).first()
	if moneda is None:
		return jsonify({'mensaje': 'Moneda no existe'}), 404

	return jsonify({'moneda': moneda.json() })

@moneda_bp.route('/', methods=['POST'])
def create_moneda():
	json = request.get_json(force=True)

	if json.get('sigla') is None or json.get('nombre') is None:
		return jsonify({'mensaje': 'El formato está mal'}), 400

	moneda = Moneda.create(json['sigla'],json['nombre'])
	if moneda == False:
			return jsonify({'mensaje': 'Uno de los valores No Existe'}), 400

	return jsonify({'moneda':moneda.json()})

@moneda_bp.route('/<id_moneda>', methods=['PUT'])
def edit_moneda(id_moneda):
	moneda = Moneda.query.filter_by(id=id_moneda).first()
	if moneda is None:
		return jsonify({'mensaje': 'Moneda no existe'}), 404

	json = request.get_json(force=True)
	if json.get('nombre') is None:
		return jsonify({'message': 'Bad request'}), 400

	moneda.nombre = json['nombre']
	moneda.sigla = json['sigla']

	moneda.update()

	return jsonify({'moneda': moneda.json() })

@moneda_bp.route('/<id_moneda>', methods=['DELETE'])
def delete_moneda(id_moneda):
	moneda = Moneda.query.filter_by(id=id_moneda).first()
	if moneda is None:
		return jsonify({'mensaje': 'El moneda no existe'}), 404

	moneda.delete()

	return jsonify({'moneda': moneda.json() })