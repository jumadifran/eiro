-- Table: public.rw_image_category

-- DROP TABLE public.rw_image_category;

CREATE TABLE public.rw_image_category
(
  id serial,
  view_position character varying(300) NOT NULL,
  description character varying(250),
  mandatory boolean,
  CONSTRAINT "rw_image_category: ID must be unique" PRIMARY KEY (id),
  CONSTRAINT rw_image_category_code_key UNIQUE (view_position)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.rw_image_category
  OWNER TO postgres;

-- Index: public.rw_image_category_id_idx

-- DROP INDEX public.rw_image_category_id_idx;

CREATE INDEX rw_image_category_id_idx
  ON public.rw_image_category
  USING btree
  (id);


-- Table: public.rw_inspection

-- DROP TABLE public.rw_inspection;

CREATE TABLE public.rw_inspection
(
  id serial,
  rw_inspection_date date,
  purchaseorder_item_id integer,
  ebako_code character varying,
  customer_code character varying,
  client_id integer,
  client_name character varying,
  submited boolean DEFAULT false,
  user_added character varying,
  added_time timestamp without time zone,
  user_updated character varying,
  updated_time timestamp without time zone,
  po_client_no character varying,
  CONSTRAINT rw_inspection_pkey PRIMARY KEY (id),
  CONSTRAINT rw_inspection_poitem_fkey FOREIGN KEY (purchaseorder_item_id)
      REFERENCES public.purchaseorder_item (id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE
)
WITH (
  OIDS=FALSE,
  autovacuum_enabled=true
);
ALTER TABLE public.rw_inspection
  OWNER TO postgres;

-- Index: public.rw_inspection_id_idx

-- DROP INDEX public.rw_inspection_id_idx;

CREATE INDEX rw_inspection_id_idx
  ON public.rw_inspection
  USING btree
  (id);


-- Table: public.rw_inspection_detail

-- DROP TABLE public.rw_inspection_detail;

CREATE TABLE public.rw_inspection_detail
(
  id serial,
  rw_inspection_id integer,
  rw_image_category_id integer,
  filename character varying,
  user_added character varying,
  added_time timestamp without time zone,
  user_updated character varying,
  updated_time timestamp without time zone,
  CONSTRAINT rw_inspection_detail_pkey PRIMARY KEY (id),
  CONSTRAINT rw_inspection_fkey FOREIGN KEY (rw_inspection_id)
      REFERENCES public.rw_inspection (id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE
)
WITH (
  OIDS=FALSE,
  autovacuum_enabled=true
);
ALTER TABLE public.rw_inspection_detail
  OWNER TO postgres;

-- Index: public.rw_inspection_detail_id_idx

-- DROP INDEX public.rw_inspection_detail_id_idx;

CREATE INDEX rw_inspection_detail_id_idx
  ON public.rw_inspection_detail
  USING btree
  (id);



-- Function: public.trg_insert_rw_inspection()

-- DROP FUNCTION public.trg_insert_rw_inspection();

CREATE OR REPLACE FUNCTION public.trg_insert_rw_inspection()
  RETURNS trigger AS
$BODY$
declare
	_record record;
	
begin
	if TG_OP = 'INSERT' then
		for _record in
			select * from rw_image_category order by id
		loop
			
			insert into rw_inspection_detail(rw_inspection_id,rw_image_category_id) 
			values(New.id,_record.id);
		end loop;
		
	elseif TG_OP = 'DELETE' then
		delete from rw_inspection_detail where rw_inspection_id=Old.id;
	end if;
	return null;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.trg_insert_rw_inspection()
  OWNER TO postgres;

-- Trigger: trg_insert_new_rw_inspection on public.rw_inspection

-- DROP TRIGGER trg_insert_new_rw_inspection ON public.rw_inspection;

CREATE TRIGGER trg_insert_new_rw_inspection
  AFTER INSERT OR DELETE
  ON public.rw_inspection
  FOR EACH ROW
  EXECUTE PROCEDURE public.trg_insert_rw_inspection();


INSERT INTO public.menugroup (id, label, icon, apps_type)
VALUES (8, 'Raw Material Inspection', 'icon-tracking', 'EIRO');

INSERT INTO public.menu (id, controller, label, menugroupid, icon, actions, apps_type)
VALUES(60, 'rw_image_category', 'RM Image Category', 8, 'icon_inspection', 'Add|Edit|Delete', 'EIRO');

INSERT INTO public.menu (id, controller, label, menugroupid, icon, actions, apps_type)
VALUES(61, 'rw_inspection_list', 'RM Inspection List', 8, 'icon_inspection', 'Add|Edit|Delete', 'EIRO');

INSERT INTO public.menu (id, controller, label, menugroupid, icon, actions, apps_type)
VALUES(62, 'rw_inspection_summary', 'RM Inspection Summary', 8, 'icon_inspection', 'Add|Edit|Delete', 'EIRO');

-- Function: public.trg_insert_inspection_from_poitem()

-- DROP FUNCTION public.trg_insert_inspection_from_poitem();

CREATE OR REPLACE FUNCTION public.trg_insert_inspection_from_poitem()
  RETURNS trigger AS
$BODY$
declare
	_record record;
	
begin
	if TG_OP = 'INSERT' then
		for _record in
			select poi.*,c.name client_name,po.po_client_no,p.ebako_code,p.customer_code,c.id client_id,p.description,p.material,p.finishing  from purchaseorder_item poi 
			JOIN purchaseorder po on po.id=poi.purchaseorder_id  JOIN products p on poi.product_id=p.id  JOIN client c on c.id=po.client_id where poi.id=New.id  order by poi.id
		loop
			
			insert into inspection(purchaseorder_item_id,ebako_code,customer_code,client_id,client_name,po_client_no,user_added,added_time) 
			values(New.id,_record.ebako_code,_record.customer_code,_record.client_id,_record.client_name,_record.po_client_no,_record.user_added,now());
			insert into rw_inspection(purchaseorder_item_id,ebako_code,customer_code,client_id,client_name,po_client_no,user_added,added_time) 
			values(New.id,_record.ebako_code,_record.customer_code,_record.client_id,_record.client_name,_record.po_client_no,_record.user_added,now());
		end loop;
		
	elseif TG_OP = 'DELETE' then
		delete from inspection where purchaseorder_item_id=Old.id;
		delete from rw_inspection where purchaseorder_item_id=Old.id;
	end if;
	return null;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.trg_insert_inspection_from_poitem()
  OWNER TO postgres;
