from models import Pais
from flask import Blueprint
from flask import jsonify
from flask import request

pais_bp = Blueprint('pais_bp', __name__)

@pais_bp.route('/', methods=['GET'])
def get_paises():
	#paises = Pais.query.all()
	paises  = [ pais.json() for pais in Pais.query.all() ]
	return jsonify({'paises': paises})
	#render_template('pais.html', data = paises)


@pais_bp.route('/<cod_pais>', methods=['GET'])
def get_pais(cod_pais):
	pais = Pais.query.filter_by(cod_pais=cod_pais).first()
	if pais is None:
		return jsonify({'mensaje': 'Pais no existe'}), 404

	return jsonify({'pais': pais.json() })

@pais_bp.route('/', methods=['POST'])
def create_pais():
	json = request.get_json(force=True)

	if json.get('nombre') is None:
		return jsonify({'mensaje': 'El formato está mal'}), 400

	pais = Pais.create(json['nombre'])
	if pais == False:
			return jsonify({'mensaje': 'Uno de los valores No Existe'}), 400

	return jsonify({'pais':pais.json()})

@pais_bp.route('/<cod_pais>', methods=['PUT'])
def edit_pais(cod_pais):
	pais = Pais.query.filter_by(cod_pais=cod_pais).first()
	if pais is None:
		return jsonify({'mensaje': 'Pais no existe'}), 404

	json = request.get_json(force=True)
	if json.get('nombre') is None:
		return jsonify({'message': 'Bad request'}), 400
	
	pais.nombre = json['nombre']
	

	pais.update()

	return jsonify({'pais': pais.json() })

@pais_bp.route('/<cod_pais>', methods=['DELETE'])
def delete_pais(cod_pais):
	pais = Pais.query.filter_by(cod_pais=cod_pais).first()
	if pais is None:
		return jsonify({'mensaje': 'El pais no existe'}), 404

	pais.delete()

	return jsonify({'pais': pais.json() })