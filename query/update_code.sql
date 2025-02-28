update fabric set code=(select code from fabric as f2 where fabric.id=f2.id)


ALTER TABLE public.purchaseorder_item ADD COLUMN line character varying;
ALTER TABLE public.shipment ADD COLUMN loadibility character varying;
ALTER TABLE public.products ADD COLUMN client_id integer;


ALTER TABLE public.purchaseorder ADD COLUMN po_client_no character varying;
ALTER TABLE public.purchaseorder ADD COLUMN ship_to text;
ALTER TABLE public.shipment ADD COLUMN tally_user character varying;