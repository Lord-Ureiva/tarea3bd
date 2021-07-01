PGDMP                 
        y            Tarea-1    12.6    12.6     .           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            /           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            0           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            1           1262    24577    Tarea-1    DATABASE     �   CREATE DATABASE "Tarea-1" WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'Spanish_Spain.1252' LC_CTYPE = 'Spanish_Spain.1252';
    DROP DATABASE "Tarea-1";
                postgres    false            �            1259    24581    cuenta_bancaria    TABLE     �   CREATE TABLE public.cuenta_bancaria (
    numero_cuenta integer NOT NULL,
    id_usuario integer NOT NULL,
    balance numeric NOT NULL
);
 #   DROP TABLE public.cuenta_bancaria;
       public         heap    postgres    false            �            1259    24587    moneda    TABLE     �   CREATE TABLE public.moneda (
    id integer NOT NULL,
    sigla character varying(10) NOT NULL,
    nombre character varying(80) NOT NULL
);
    DROP TABLE public.moneda;
       public         heap    postgres    false            �            1259    24590    pais    TABLE     g   CREATE TABLE public.pais (
    cod_pais integer NOT NULL,
    nombre character varying(45) NOT NULL
);
    DROP TABLE public.pais;
       public         heap    postgres    false            �            1259    24593    precio_moneda    TABLE     �   CREATE TABLE public.precio_moneda (
    id_moneda integer NOT NULL,
    fecha timestamp without time zone NOT NULL,
    valor numeric NOT NULL
);
 !   DROP TABLE public.precio_moneda;
       public         heap    postgres    false            �            1259    24599    usuario    TABLE     V  CREATE TABLE public.usuario (
    id integer NOT NULL,
    nombre character varying(50) NOT NULL,
    apellido character varying(50),
    correo character varying(50) NOT NULL,
    "contraseña" character varying(256) NOT NULL,
    pais integer NOT NULL,
    fecha_registro timestamp without time zone NOT NULL,
    admin boolean NOT NULL
);
    DROP TABLE public.usuario;
       public         heap    postgres    false            �            1259    24771    usuario_id_seq    SEQUENCE     �   ALTER TABLE public.usuario ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.usuario_id_seq
    START WITH 29
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);
            public          postgres    false    206            �            1259    24602    usuario_tiene_moneda    TABLE     �   CREATE TABLE public.usuario_tiene_moneda (
    id_usuario integer NOT NULL,
    id_moneda integer NOT NULL,
    balance numeric NOT NULL
);
 (   DROP TABLE public.usuario_tiene_moneda;
       public         heap    postgres    false            %          0    24581    cuenta_bancaria 
   TABLE DATA           M   COPY public.cuenta_bancaria (numero_cuenta, id_usuario, balance) FROM stdin;
    public          postgres    false    202   �"       &          0    24587    moneda 
   TABLE DATA           3   COPY public.moneda (id, sigla, nombre) FROM stdin;
    public          postgres    false    203   r#       '          0    24590    pais 
   TABLE DATA           0   COPY public.pais (cod_pais, nombre) FROM stdin;
    public          postgres    false    204   $       (          0    24593    precio_moneda 
   TABLE DATA           @   COPY public.precio_moneda (id_moneda, fecha, valor) FROM stdin;
    public          postgres    false    205   �$       )          0    24599    usuario 
   TABLE DATA           k   COPY public.usuario (id, nombre, apellido, correo, "contraseña", pais, fecha_registro, admin) FROM stdin;
    public          postgres    false    206   h+       *          0    24602    usuario_tiene_moneda 
   TABLE DATA           N   COPY public.usuario_tiene_moneda (id_usuario, id_moneda, balance) FROM stdin;
    public          postgres    false    207   �0       2           0    0    usuario_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.usuario_id_seq', 36, true);
          public          postgres    false    208            �
           2606    24609 $   cuenta_bancaria cuenta_bancaria_pkey 
   CONSTRAINT     m   ALTER TABLE ONLY public.cuenta_bancaria
    ADD CONSTRAINT cuenta_bancaria_pkey PRIMARY KEY (numero_cuenta);
 N   ALTER TABLE ONLY public.cuenta_bancaria DROP CONSTRAINT cuenta_bancaria_pkey;
       public            postgres    false    202            �
           2606    24611    moneda moneda_pkey 
   CONSTRAINT     P   ALTER TABLE ONLY public.moneda
    ADD CONSTRAINT moneda_pkey PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.moneda DROP CONSTRAINT moneda_pkey;
       public            postgres    false    203            �
           2606    24613    pais pais_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.pais
    ADD CONSTRAINT pais_pkey PRIMARY KEY (cod_pais);
 8   ALTER TABLE ONLY public.pais DROP CONSTRAINT pais_pkey;
       public            postgres    false    204            �
           2606    24615     precio_moneda precio_moneda_pkey 
   CONSTRAINT     l   ALTER TABLE ONLY public.precio_moneda
    ADD CONSTRAINT precio_moneda_pkey PRIMARY KEY (id_moneda, fecha);
 J   ALTER TABLE ONLY public.precio_moneda DROP CONSTRAINT precio_moneda_pkey;
       public            postgres    false    205    205            �
           2606    24617    usuario usuario_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.usuario
    ADD CONSTRAINT usuario_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.usuario DROP CONSTRAINT usuario_pkey;
       public            postgres    false    206            �
           2606    24619 .   usuario_tiene_moneda usuario_tiene_moneda_pkey 
   CONSTRAINT        ALTER TABLE ONLY public.usuario_tiene_moneda
    ADD CONSTRAINT usuario_tiene_moneda_pkey PRIMARY KEY (id_usuario, id_moneda);
 X   ALTER TABLE ONLY public.usuario_tiene_moneda DROP CONSTRAINT usuario_tiene_moneda_pkey;
       public            postgres    false    207    207            �
           2606    24784 /   cuenta_bancaria cuenta_bancaria_id_usuario_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.cuenta_bancaria
    ADD CONSTRAINT cuenta_bancaria_id_usuario_fkey FOREIGN KEY (id_usuario) REFERENCES public.usuario(id) ON DELETE CASCADE;
 Y   ALTER TABLE ONLY public.cuenta_bancaria DROP CONSTRAINT cuenta_bancaria_id_usuario_fkey;
       public          postgres    false    206    2719    202            �
           2606    24625 *   precio_moneda precio_moneda_id_moneda_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.precio_moneda
    ADD CONSTRAINT precio_moneda_id_moneda_fkey FOREIGN KEY (id_moneda) REFERENCES public.moneda(id);
 T   ALTER TABLE ONLY public.precio_moneda DROP CONSTRAINT precio_moneda_id_moneda_fkey;
       public          postgres    false    2713    205    203            �
           2606    24630    usuario usuario_pais_fkey    FK CONSTRAINT     z   ALTER TABLE ONLY public.usuario
    ADD CONSTRAINT usuario_pais_fkey FOREIGN KEY (pais) REFERENCES public.pais(cod_pais);
 C   ALTER TABLE ONLY public.usuario DROP CONSTRAINT usuario_pais_fkey;
       public          postgres    false    2715    206    204            �
           2606    24779 8   usuario_tiene_moneda usuario_tiene_moneda_id_moneda_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.usuario_tiene_moneda
    ADD CONSTRAINT usuario_tiene_moneda_id_moneda_fkey FOREIGN KEY (id_moneda) REFERENCES public.moneda(id) ON DELETE CASCADE;
 b   ALTER TABLE ONLY public.usuario_tiene_moneda DROP CONSTRAINT usuario_tiene_moneda_id_moneda_fkey;
       public          postgres    false    203    2713    207            �
           2606    24774 9   usuario_tiene_moneda usuario_tiene_moneda_id_usuario_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.usuario_tiene_moneda
    ADD CONSTRAINT usuario_tiene_moneda_id_usuario_fkey FOREIGN KEY (id_usuario) REFERENCES public.usuario(id) ON DELETE CASCADE;
 c   ALTER TABLE ONLY public.usuario_tiene_moneda DROP CONSTRAINT usuario_tiene_moneda_id_usuario_fkey;
       public          postgres    false    207    2719    206            %   �   x��ɍQC���=��?�q��%-��[mZ�-�ԑ�[{Х�:�ӓ�N�VB�7��;��ް8�O����T�H�^�)����-S��>B�߳&�G�}6�<a�n�
�l��qE|�2�7����/��e������*f      &   �   x�-��
�@���>�O�[g��N`�F�b:#z}��ڝ��#�
��:8O���T�<���f6�^����B���{<
ma���fM��B�m�!2S�~�#�<C���e:!Q�?�:C��l�Q\�²��T�D��2�kED!�2�      '   t   x���1���p��Ox�. �DF��V�l�>'tC-4�F��`��U�p�����Y�!��KS�0�EBi���=�[S�coK���#.9O�Fq!&7��3��Y�6׏�"�i�#E      (   �  x�]XK�9[�;E.���}���9F�ӆL�[d���-�h��n�n��2��}L����7���$�_�/�ف,Y�V �_�_����=��n�jz�v�_���Y"��t]m<�����j� u������{������ȃ�FWd\�)yl�����7b7�X�g����,�'����Y��6{r�2q0a~�qv������Kg�!���/;��?�@a�4�,�lO�7d"�R+Ӟ:���H��������^r����[��6�E���XѬ�zɼ�\}?i�X�o�Hj �m���ʖΠ�TZ;�.X>�j�Y�Mr���Ҋ#/��S�ىhu�@셼��YF����ED͑����/��"oZ!���A�eD{oX�Ӯ2�5@�S����@f���E�M�l���u��ED������72 �r���`���Z�<�Y0�K���bE�9�غzBX�
��o�^�UoH�+ܥ��ү%����+�wmi�b�?܅v��B�I�]hg�l\r �Ȩ�r	y�|�ط%�Q;�r���ݓt����- ]?��ꮳpa��,�"��M�t�7N�QF���2Nj�8���Yf����Q��Ir�݄�P�qg3rD�#�E ���{�  �+��w:��"��|�h�2��+=Jԯ�U� i2b�5>dE/t)�[[�h��*z�����J��Rx�@�A���@'g��=?dFV��(ɲct�$q���:!=⎙�:���2#�l�P��ˊ���D	�xsV�"�b4����L?�H�{FTr��3��Pa�@B�H[Ǣb��
�iը@I�	�d�b@�9K@l��#ZPf�!7qC��D�p��?��S|��i(EBn_�s&7��'�{,j(�,U�V!�]:V��fO��!kwY�����w��=��Qxe�2k��&���sȥo�ݙ �y��CnT����ȞNY`�B2L�刘��A��ʢ;Wyh�����^.�J'DcEO��S+������l.k�4rkl.�c)�oAݻ��~՘�o��,}�\�O�J=����D@-6�"�%f6@l���y��B'��m,Q2J���w*{+�H+�Bb���0��&���c�8����ѐ�1�\-���E��yt�@zttl��9��^ z�+s��+��Q�Z8�.Z��	!?���[��;��{{G�Wvt����� u�Q"+J�����ʾ�S.��w�>=$1q��PԸ3v�Њ1�e�]J)ܧCH����b��ᬐ����"Y�,C�;�+)GDri�츐�l˺�h����
�����r+��,[�B�Խ4OO���%�"���d��e�y�ʾG�,�{>C��n5�rCy@�*}Xù�c�>�����wh@v����)��0Εce�Q�^y&��>��/S�lӲKrG\┕2�n뭞���p�>1:��B�Bc����prYf4�h%f��{ղگ�b8���!�-�`vt��U���� ť����+1~�ח$��'����K�7?U$�$��+��්���f�\=��[0�P&'A��VL�%�5/G���g@���Y�Ǭ����:勑��n̊ΪrRx�o,�HO/�cŢ#���Y��T���&�uڣW�-28ɞ~� @��Ď��,��ӟ��K�״��E�V�c�W�V!���<ʦ�Q�VGzr�������������b      )   �  x�eVIs�<=+�bsE#ɲNx�BHX�ɐ�.�8����f���?�f28�U?W������q�)p�6i�+r�0&'8(���(�0*6 Cĉ����Y��~ �o>�傁a���J�[��U�'l��������8X'>ѳ�9#UFqV����2��m��J����$
]��#02���BfI�K�%��	a��OY���ǅ��#m���X�s	|U�
��(Si��M��D�&�!�siؤ)�s6-�*��<�Ѻ����ă��}���9ؓ!	<L;H���4YVA�ϲ����j�EC��6�<�/y���N�����������!�L�Q&uX@��8D��^iݻ�p��8n�ϗzԀ2.N�3o�@��Cz���>Q��VK�Gi�*0��Q�`i�Y'8c�4���C N}�_�l����T�� �|�H(����0r���	��ˬ(�0��s]]V�->�-��1	�)y��im���F�;ͩʝ�m�B5�����Av�C��ල݂�,U�ƽ����QV̓�����NW\B|�q(�t[V];���a�Yĥ.z�F�*�`}z �����bϲ����9������J����21\����ے2GX�"�+g�v�=/��FQ�(u����g�(e.s���L�O]��.
�,}aV�K�����0�ؔ	?Щ����u�Al�w)��//���.Mt6(�CD�b�<��A������'W�t��` �`b�fd�vn�g���)�#�Ya~-������&�IꟘ�\a�M��&L����\�A���ӻI 'ɻy����J�֯k�:�s���yJ�����af��B�� Ђ��Ciɇ4����8	�����*�� ����]vO�+�_��zrs��<ܯ��KuĻh���[��|���c��%�����wڶ�	��'��쫍�����C�|�á��l��x�u��GFۏ���%��w1Z���1��e�n�&}bAA0�ms��6���f����`����8R��-xXގ]V��l�����9�(�a���T�_��榾��گ�=�L�I�>�#k[�����{�yO����o޶7�77v��\�����8�}�#��Py.y������98l��_V��Vߖ�i�f��(j��
��Ei�4����ٟ:Ʃ��+�����O�s칻�$�q5�ד�%��w���*�T�ɿ��L��Q̥Q`�Y��y�7���}O/�wI���O3�z�QD�b�;Kے��������v>�m�pǫ�����~#%'6�&=���񱪪c�Mr����s�����St�i�4�98����p2�������m���~��߅3l�����]tn��O($B�n��^\\��D��      *   �   x���D1B�Z�F�e��c���@�r%�i��@��µV�B?bI7:����:�2�"��%�E[d����l�[�>3�C��Rsz��g���Q��G}�$����b��	�[yj1eӋ!a��n�Y#z���O���;��<o����l��̗N����'=x�X2�K���w�����@6�     