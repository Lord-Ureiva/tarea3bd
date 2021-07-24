#from models import usuarios_año
from flask import Blueprint
from flask import jsonify
from flask import request
from models import db

consultas_bp = Blueprint('consultas_bp', __name__)

#-----------------------------------------------------------------------------------------------------------
#1
#-----------------------------------------------------------------------------------------------------------
def usuarios_año(año):
	try:
		result = db.session.execute('SELECT nombre as "Nombre",  apellido as "Apellido", DATE(fecha_registro) as "Fecha Registro" FROM usuario WHERE EXTRACT(YEAR FROM fecha_registro) ='+str(año))
		return result

	except:
		return False

@consultas_bp.route("/1/<anno>",methods=['GET'])
def get_usuarios_año(anno):
 
    personas = [dict(personas) for personas in usuarios_año(anno).fetchall()]
    for elem in personas:
        if "Apellido" not in elem:
            elem["Apellido"] = ""

    return jsonify({'personas': personas })
      

#-----------------------------------------------------------------------------------------------------------
#2
#-----------------------------------------------------------------------------------------------------------

def get_cuenta_bancaria(valor):
    try:
	    result = db.session.execute("""SELECT
    numero_cuenta as "Id Cuenta", balance as "Balance"
FROM 
    cuenta_bancaria
WHERE
    balance >= """+str(valor))
	    return result

    except:
	    return False


@consultas_bp.route("/2/<valor>",methods=['GET'])
def get_cuentas(valor):
   #valor = 3000    #INSERTAR VALOR
   cuentas = [dict(cuenta) for cuenta in get_cuenta_bancaria(valor).fetchall()]
   for id_c in cuentas:
      id_c['Balance'] = float(id_c["Balance"])


   return jsonify({'cuentas': cuentas })

#-----------------------------------------------------------------------------------------------------------
#3
#-----------------------------------------------------------------------------------------------------------

def usuarios_pais(pais):
   try:
	   result = db.session.execute("""SELECT
         pais.nombre as "Pais", usuario.nombre as "Nombre", usuario.apellido as "Apellido"
         FROM 
         pais
    INNER JOIN usuario
    ON usuario.pais = pais.cod_pais
WHERE
    pais.nombre = '{}' """.format(pais))
	   return result

   except:
	   return False



@consultas_bp.route("/3/<pais>",methods=['GET'])
def get_usuarios_pais(pais): 
   cuentas = [dict(cuenta) for cuenta in usuarios_pais(pais).fetchall()]
   return jsonify({'cuentas': cuentas })


#-----------------------------------------------------------------------------------------------------------
#4
#-----------------------------------------------------------------------------------------------------------

def valor_historico(moneda):
   try:
      result = db.session.execute("""SELECT moneda.nombre as "Nombre",MAX(precio_moneda.valor) as "max_valor"
FROM 
   precio_moneda INNER JOIN moneda
ON precio_moneda.id_moneda = moneda.id
WHERE
   moneda.nombre = '{}'
GROUP BY
   moneda.nombre;""".format(moneda))

      return result

   except:
	   return False

@consultas_bp.route("/4/<moneda>",methods=['GET'])
def get_valor_hist(moneda):
   valores = [dict(valor) for valor in valor_historico(moneda).fetchall()]
   for dic in valores:
      dic["max_valor"]=float(dic["max_valor"])
   return jsonify({'valores': valores })

#-----------------------------------------------------------------------------------------------------------
#5
#-----------------------------------------------------------------------------------------------------------

def monedas_circulacion(moneda):
      try:
	      result = db.session.execute("""SELECT 
    Nombre as "nombre", SUM(usuario_tiene_moneda.balance) as "Cantidad Total"
FROM 
    moneda INNER JOIN usuario_tiene_moneda ON moneda.id = usuario_tiene_moneda.id_moneda
WHERE
    nombre = '{}'
    
GROUP BY nombre""".format(moneda))
	      return result

      except:
	      return False


@consultas_bp.route("/5/<nombre>",methods=['GET'])
def get_monedas(nombre):
   monedas = [dict(monedas) for monedas in monedas_circulacion(nombre).fetchall()]
   for moneda in monedas:
      moneda['Cantidad Total'] = float(moneda['Cantidad Total'])
   return jsonify({'monedas': monedas }) 



#-----------------------------------------------------------------------------------------------------------
#6
#-----------------------------------------------------------------------------------------------------------

def top_monedas():
    try:
        result = db.session.execute("""SELECT 
    nombre as "Nombre", COUNT(usuario_tiene_moneda.id_moneda) as "Cantidad Usuarios"
FROM 
    moneda INNER JOIN usuario_tiene_moneda ON moneda.id = usuario_tiene_moneda.id_moneda    
GROUP BY nombre
ORDER BY COUNT(usuario_tiene_moneda.id_moneda) DESC
LIMIT 3""")
        return result
    except:
        return False

@consultas_bp.route("/6", methods=['GET'])
def get_top_monedas():
    monedas = [dict(monedas) for monedas in top_monedas().fetchall()]
    return jsonify({'top_monedas': monedas})

#-----------------------------------------------------------------------------------------------------------
#7
#-----------------------------------------------------------------------------------------------------------

def more_change(mes):
    try:
        result = db.session.execute("""
        SELECT
    moneda.nombre "Moneda", COUNT(precio_moneda.valor) "changes"
FROM 
    precio_moneda INNER JOIN moneda ON precio_moneda.id_moneda = moneda.id
WHERE
    EXTRACT(MONTH FROM precio_moneda.fecha) = {}
GROUP BY
    moneda.nombre
ORDER BY
    "changes" DESC
LIMIT 1""".format(mes))
        return result
    except:
        return False

@consultas_bp.route("/7/<mes>", methods=['GET'])
def coin_more_change_in_month(mes):
    changeable_coin = [dict(changeable_coin) for changeable_coin in more_change(mes).fetchall()]
    return jsonify({'cambio': changeable_coin})


#-----------------------------------------------------------------------------------------------------------
#8
#-----------------------------------------------------------------------------------------------------------

def most_abundant_crypto(user):
    try:
        result = db.session.execute("""SELECT
    usuario.nombre as "Nombre", usuario.apellido as "Apellido", moneda.nombre as "Nombre Moneda", usuario_tiene_moneda.balance as "Cantidad"  
FROM 
    usuario
	INNER JOIN usuario_tiene_moneda ON usuario.id = usuario_tiene_moneda.id_usuario 
	INNER JOIN moneda ON usuario_tiene_moneda.id_moneda = moneda.id

WHERE
    usuario.id = {}   

ORDER BY usuario_tiene_moneda.balance DESC
LIMIT 1""".format(user))
        return result
    except:
        return False

@consultas_bp.route("/8/<user>", methods=['GET'])
def get_abundant_crypto(user):
    abundant = [dict(abundant) for abundant in most_abundant_crypto(user).fetchall()]
    for abundan in abundant:
        abundan['Cantidad'] = float(abundan['Cantidad'])
    return jsonify({'abundant': abundant})
