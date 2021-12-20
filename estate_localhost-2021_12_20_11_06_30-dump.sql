--
-- PostgreSQL database dump
--

-- Dumped from database version 12.9 (Ubuntu 12.9-0ubuntu0.20.04.1)
-- Dumped by pg_dump version 13.4 (Ubuntu 13.4-1.pgdg20.04+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: bulding_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.bulding_types (
    id bigint NOT NULL,
    name character varying(255) NOT NULL
);


ALTER TABLE public.bulding_types OWNER TO postgres;

--
-- Name: bulding_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.bulding_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.bulding_types_id_seq OWNER TO postgres;

--
-- Name: bulding_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.bulding_types_id_seq OWNED BY public.bulding_types.id;


--
-- Name: currency_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.currency_types (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    symbol character varying(255) NOT NULL,
    is_current boolean DEFAULT false NOT NULL,
    rate double precision DEFAULT '1'::double precision NOT NULL
);


ALTER TABLE public.currency_types OWNER TO postgres;

--
-- Name: currency_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.currency_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.currency_types_id_seq OWNER TO postgres;

--
-- Name: currency_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.currency_types_id_seq OWNED BY public.currency_types.id;


--
-- Name: deal_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.deal_types (
    id bigint NOT NULL,
    name character varying(255) NOT NULL
);


ALTER TABLE public.deal_types OWNER TO postgres;

--
-- Name: deal_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.deal_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.deal_types_id_seq OWNER TO postgres;

--
-- Name: deal_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.deal_types_id_seq OWNED BY public.deal_types.id;


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.failed_jobs_id_seq OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: filter_groups; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.filter_groups (
    id bigint NOT NULL,
    name character varying(255) NOT NULL
);


ALTER TABLE public.filter_groups OWNER TO postgres;

--
-- Name: filter_groups_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.filter_groups_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.filter_groups_id_seq OWNER TO postgres;

--
-- Name: filter_groups_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.filter_groups_id_seq OWNED BY public.filter_groups.id;


--
-- Name: filter_property_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.filter_property_types (
    id bigint NOT NULL,
    filter_id bigint NOT NULL,
    property_type_id bigint NOT NULL
);


ALTER TABLE public.filter_property_types OWNER TO postgres;

--
-- Name: filter_property_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.filter_property_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.filter_property_types_id_seq OWNER TO postgres;

--
-- Name: filter_property_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.filter_property_types_id_seq OWNED BY public.filter_property_types.id;


--
-- Name: filters; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.filters (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    filter_group_id bigint,
    deal_type character varying(255),
    CONSTRAINT filters_deal_type_check CHECK (((deal_type)::text = ANY ((ARRAY['sell'::character varying, 'rent'::character varying])::text[])))
);


ALTER TABLE public.filters OWNER TO postgres;

--
-- Name: filters_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.filters_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.filters_id_seq OWNER TO postgres;

--
-- Name: filters_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.filters_id_seq OWNED BY public.filters.id;


--
-- Name: filters_values; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.filters_values (
    id bigint NOT NULL,
    filter_id bigint NOT NULL,
    property_id bigint NOT NULL,
    value character varying(255)
);


ALTER TABLE public.filters_values OWNER TO postgres;

--
-- Name: filters_values_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.filters_values_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.filters_values_id_seq OWNER TO postgres;

--
-- Name: filters_values_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.filters_values_id_seq OWNED BY public.filters_values.id;


--
-- Name: jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


ALTER TABLE public.jobs OWNER TO postgres;

--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.jobs_id_seq OWNER TO postgres;

--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- Name: languages; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.languages (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    code character varying(255) NOT NULL,
    flag_image character varying(255) NOT NULL
);


ALTER TABLE public.languages OWNER TO postgres;

--
-- Name: languages_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.languages_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.languages_id_seq OWNER TO postgres;

--
-- Name: languages_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.languages_id_seq OWNED BY public.languages.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.migrations_id_seq OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: notification_users_properties; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.notification_users_properties (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    property_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.notification_users_properties OWNER TO postgres;

--
-- Name: notification_users_properties_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.notification_users_properties_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.notification_users_properties_id_seq OWNER TO postgres;

--
-- Name: notification_users_properties_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.notification_users_properties_id_seq OWNED BY public.notification_users_properties.id;


--
-- Name: oauth_access_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.oauth_access_tokens (
    id character varying(100) NOT NULL,
    user_id bigint,
    client_id bigint NOT NULL,
    name character varying(255),
    scopes text,
    revoked boolean NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone
);


ALTER TABLE public.oauth_access_tokens OWNER TO postgres;

--
-- Name: oauth_auth_codes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.oauth_auth_codes (
    id character varying(100) NOT NULL,
    user_id bigint NOT NULL,
    client_id bigint NOT NULL,
    scopes text,
    revoked boolean NOT NULL,
    expires_at timestamp(0) without time zone
);


ALTER TABLE public.oauth_auth_codes OWNER TO postgres;

--
-- Name: oauth_clients; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.oauth_clients (
    id bigint NOT NULL,
    user_id bigint,
    name character varying(255) NOT NULL,
    secret character varying(100),
    provider character varying(255),
    redirect text NOT NULL,
    personal_access_client boolean NOT NULL,
    password_client boolean NOT NULL,
    revoked boolean NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.oauth_clients OWNER TO postgres;

--
-- Name: oauth_clients_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.oauth_clients_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.oauth_clients_id_seq OWNER TO postgres;

--
-- Name: oauth_clients_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.oauth_clients_id_seq OWNED BY public.oauth_clients.id;


--
-- Name: oauth_personal_access_clients; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.oauth_personal_access_clients (
    id bigint NOT NULL,
    client_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.oauth_personal_access_clients OWNER TO postgres;

--
-- Name: oauth_personal_access_clients_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.oauth_personal_access_clients_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.oauth_personal_access_clients_id_seq OWNER TO postgres;

--
-- Name: oauth_personal_access_clients_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.oauth_personal_access_clients_id_seq OWNED BY public.oauth_personal_access_clients.id;


--
-- Name: oauth_refresh_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.oauth_refresh_tokens (
    id character varying(100) NOT NULL,
    access_token_id character varying(100) NOT NULL,
    revoked boolean NOT NULL,
    expires_at timestamp(0) without time zone
);


ALTER TABLE public.oauth_refresh_tokens OWNER TO postgres;

--
-- Name: password_resets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_resets (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_resets OWNER TO postgres;

--
-- Name: phones; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.phones (
    id bigint NOT NULL,
    number character varying(255) NOT NULL,
    viber boolean DEFAULT false NOT NULL,
    whatsapp boolean DEFAULT false NOT NULL,
    telegram boolean DEFAULT false NOT NULL,
    user_id bigint NOT NULL
);


ALTER TABLE public.phones OWNER TO postgres;

--
-- Name: phones_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.phones_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.phones_id_seq OWNER TO postgres;

--
-- Name: phones_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.phones_id_seq OWNED BY public.phones.id;


--
-- Name: properties; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.properties (
    id bigint NOT NULL,
    property_key character varying(255),
    property_type_id bigint,
    user_id bigint,
    bulding_type_id bigint,
    latitude double precision,
    longitude double precision,
    address character varying(255),
    postal_code character varying(255),
    property_state character varying(255),
    review text,
    is_public_status character varying(255) DEFAULT 'under_review'::character varying NOT NULL,
    is_save boolean DEFAULT false NOT NULL,
    is_delete boolean DEFAULT false NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    email character varying(255),
    view integer DEFAULT 0 NOT NULL,
    is_address_precise boolean DEFAULT true NOT NULL,
    update_count integer DEFAULT 0 NOT NULL,
    next_update timestamp(0) without time zone,
    last_update timestamp(0) without time zone,
    is_archive boolean DEFAULT false NOT NULL,
    is_bids boolean DEFAULT false NOT NULL,
    CONSTRAINT properties_is_public_status_check CHECK (((is_public_status)::text = ANY ((ARRAY['under_review'::character varying, 'published'::character varying, 'rejected'::character varying])::text[]))),
    CONSTRAINT properties_property_state_check CHECK (((property_state)::text = ANY ((ARRAY['good'::character varying, 'average'::character varying, 'poor'::character varying])::text[])))
);


ALTER TABLE public.properties OWNER TO postgres;

--
-- Name: properties_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.properties_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.properties_id_seq OWNER TO postgres;

--
-- Name: properties_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.properties_id_seq OWNED BY public.properties.id;


--
-- Name: property_client_ips; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.property_client_ips (
    id bigint NOT NULL,
    property_id bigint NOT NULL,
    client_ip character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.property_client_ips OWNER TO postgres;

--
-- Name: property_client_ips_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.property_client_ips_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.property_client_ips_id_seq OWNER TO postgres;

--
-- Name: property_client_ips_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.property_client_ips_id_seq OWNED BY public.property_client_ips.id;


--
-- Name: property_deals; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.property_deals (
    id bigint NOT NULL,
    property_id bigint NOT NULL,
    deal_type_id bigint NOT NULL,
    price double precision NOT NULL,
    currency_type_id bigint NOT NULL
);


ALTER TABLE public.property_deals OWNER TO postgres;

--
-- Name: property_deals_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.property_deals_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.property_deals_id_seq OWNER TO postgres;

--
-- Name: property_deals_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.property_deals_id_seq OWNED BY public.property_deals.id;


--
-- Name: property_images; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.property_images (
    id bigint NOT NULL,
    property_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    index integer DEFAULT 1 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.property_images OWNER TO postgres;

--
-- Name: property_images_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.property_images_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.property_images_id_seq OWNER TO postgres;

--
-- Name: property_images_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.property_images_id_seq OWNED BY public.property_images.id;


--
-- Name: property_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.property_types (
    id bigint NOT NULL,
    name character varying(255) NOT NULL
);


ALTER TABLE public.property_types OWNER TO postgres;

--
-- Name: property_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.property_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.property_types_id_seq OWNER TO postgres;

--
-- Name: property_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.property_types_id_seq OWNED BY public.property_types.id;


--
-- Name: save_user_filters; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.save_user_filters (
    id bigint NOT NULL,
    properties_filters jsonb,
    user_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.save_user_filters OWNER TO postgres;

--
-- Name: save_user_filters_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.save_user_filters_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.save_user_filters_id_seq OWNER TO postgres;

--
-- Name: save_user_filters_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.save_user_filters_id_seq OWNED BY public.save_user_filters.id;


--
-- Name: suggests_price_properties; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.suggests_price_properties (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    property_id bigint NOT NULL,
    price double precision NOT NULL,
    currency_type_id bigint NOT NULL,
    end_time timestamp(0) without time zone,
    is_checked boolean DEFAULT false NOT NULL,
    is_delete boolean DEFAULT false NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.suggests_price_properties OWNER TO postgres;

--
-- Name: suggests_price_properties_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.suggests_price_properties_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.suggests_price_properties_id_seq OWNER TO postgres;

--
-- Name: suggests_price_properties_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.suggests_price_properties_id_seq OWNED BY public.suggests_price_properties.id;


--
-- Name: supports; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.supports (
    id bigint NOT NULL,
    user_id bigint,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    text text NOT NULL,
    is_support_status character varying(255) DEFAULT 'new'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT supports_is_support_status_check CHECK (((is_support_status)::text = ANY ((ARRAY['new'::character varying, 'in_process'::character varying, 'done'::character varying])::text[])))
);


ALTER TABLE public.supports OWNER TO postgres;

--
-- Name: supports_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.supports_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.supports_id_seq OWNER TO postgres;

--
-- Name: supports_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.supports_id_seq OWNED BY public.supports.id;


--
-- Name: translate_descriptions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.translate_descriptions (
    id bigint NOT NULL,
    property_id bigint NOT NULL,
    language_id bigint NOT NULL,
    description text NOT NULL
);


ALTER TABLE public.translate_descriptions OWNER TO postgres;

--
-- Name: translate_descriptions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.translate_descriptions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.translate_descriptions_id_seq OWNER TO postgres;

--
-- Name: translate_descriptions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.translate_descriptions_id_seq OWNED BY public.translate_descriptions.id;


--
-- Name: translations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.translations (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    translated_name character varying(255) NOT NULL,
    language_id bigint NOT NULL
);


ALTER TABLE public.translations OWNER TO postgres;

--
-- Name: translations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.translations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.translations_id_seq OWNER TO postgres;

--
-- Name: translations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.translations_id_seq OWNED BY public.translations.id;


--
-- Name: user_favorite_properties; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.user_favorite_properties (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    property_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.user_favorite_properties OWNER TO postgres;

--
-- Name: user_favorite_properties_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.user_favorite_properties_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.user_favorite_properties_id_seq OWNER TO postgres;

--
-- Name: user_favorite_properties_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.user_favorite_properties_id_seq OWNED BY public.user_favorite_properties.id;


--
-- Name: user_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.user_types (
    id bigint NOT NULL,
    name character varying(255) NOT NULL
);


ALTER TABLE public.user_types OWNER TO postgres;

--
-- Name: user_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.user_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.user_types_id_seq OWNER TO postgres;

--
-- Name: user_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.user_types_id_seq OWNED BY public.user_types.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    full_name character varying(255) NOT NULL,
    picture character varying(255),
    email character varying(255) NOT NULL,
    user_type_id bigint NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255),
    provider character varying(255),
    provider_id character varying(255),
    remember_token character varying(100),
    first_time date,
    is_admin boolean DEFAULT false NOT NULL,
    is_delete boolean DEFAULT false NOT NULL,
    is_block boolean DEFAULT false NOT NULL,
    block_start timestamp(0) without time zone,
    block_end timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    reason text,
    last_active_time timestamp(0) without time zone
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: bulding_types id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bulding_types ALTER COLUMN id SET DEFAULT nextval('public.bulding_types_id_seq'::regclass);


--
-- Name: currency_types id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.currency_types ALTER COLUMN id SET DEFAULT nextval('public.currency_types_id_seq'::regclass);


--
-- Name: deal_types id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.deal_types ALTER COLUMN id SET DEFAULT nextval('public.deal_types_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: filter_groups id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.filter_groups ALTER COLUMN id SET DEFAULT nextval('public.filter_groups_id_seq'::regclass);


--
-- Name: filter_property_types id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.filter_property_types ALTER COLUMN id SET DEFAULT nextval('public.filter_property_types_id_seq'::regclass);


--
-- Name: filters id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.filters ALTER COLUMN id SET DEFAULT nextval('public.filters_id_seq'::regclass);


--
-- Name: filters_values id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.filters_values ALTER COLUMN id SET DEFAULT nextval('public.filters_values_id_seq'::regclass);


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- Name: languages id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.languages ALTER COLUMN id SET DEFAULT nextval('public.languages_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: notification_users_properties id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notification_users_properties ALTER COLUMN id SET DEFAULT nextval('public.notification_users_properties_id_seq'::regclass);


--
-- Name: oauth_clients id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.oauth_clients ALTER COLUMN id SET DEFAULT nextval('public.oauth_clients_id_seq'::regclass);


--
-- Name: oauth_personal_access_clients id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.oauth_personal_access_clients ALTER COLUMN id SET DEFAULT nextval('public.oauth_personal_access_clients_id_seq'::regclass);


--
-- Name: phones id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.phones ALTER COLUMN id SET DEFAULT nextval('public.phones_id_seq'::regclass);


--
-- Name: properties id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.properties ALTER COLUMN id SET DEFAULT nextval('public.properties_id_seq'::regclass);


--
-- Name: property_client_ips id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.property_client_ips ALTER COLUMN id SET DEFAULT nextval('public.property_client_ips_id_seq'::regclass);


--
-- Name: property_deals id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.property_deals ALTER COLUMN id SET DEFAULT nextval('public.property_deals_id_seq'::regclass);


--
-- Name: property_images id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.property_images ALTER COLUMN id SET DEFAULT nextval('public.property_images_id_seq'::regclass);


--
-- Name: property_types id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.property_types ALTER COLUMN id SET DEFAULT nextval('public.property_types_id_seq'::regclass);


--
-- Name: save_user_filters id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.save_user_filters ALTER COLUMN id SET DEFAULT nextval('public.save_user_filters_id_seq'::regclass);


--
-- Name: suggests_price_properties id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.suggests_price_properties ALTER COLUMN id SET DEFAULT nextval('public.suggests_price_properties_id_seq'::regclass);


--
-- Name: supports id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.supports ALTER COLUMN id SET DEFAULT nextval('public.supports_id_seq'::regclass);


--
-- Name: translate_descriptions id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.translate_descriptions ALTER COLUMN id SET DEFAULT nextval('public.translate_descriptions_id_seq'::regclass);


--
-- Name: translations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.translations ALTER COLUMN id SET DEFAULT nextval('public.translations_id_seq'::regclass);


--
-- Name: user_favorite_properties id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_favorite_properties ALTER COLUMN id SET DEFAULT nextval('public.user_favorite_properties_id_seq'::regclass);


--
-- Name: user_types id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_types ALTER COLUMN id SET DEFAULT nextval('public.user_types_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: bulding_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.bulding_types (id, name) FROM stdin;
1	excepturi
2	quisquam
3	labore
4	soluta
5	nobis
6	ullam
7	odit
8	consequatur
9	assumenda
10	quia
\.


--
-- Data for Name: currency_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.currency_types (id, name, symbol, is_current, rate) FROM stdin;
2	AMD	&#36;	t	1
1	USD	&#36;	f	481.19
3	EUR	&#128;	f	545.19
\.


--
-- Data for Name: deal_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.deal_types (id, name) FROM stdin;
1	sale
2	monthly_rental_fee
3	daily_rental_fee
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.failed_jobs (id, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: filter_groups; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.filter_groups (id, name) FROM stdin;
1	undefined
2	essentials
3	facilities_and_assets
4	heating_and_cooling
5	safety
6	location_features
7	windows_doors_floors_and_walls
8	appliances
9	furniture
\.


--
-- Data for Name: filter_property_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.filter_property_types (id, filter_id, property_type_id) FROM stdin;
1	1	1
2	2	1
3	3	1
4	4	1
5	5	1
6	6	1
7	7	1
8	8	1
9	9	1
10	12	1
11	13	1
12	14	1
13	15	1
14	16	1
15	17	1
16	18	1
17	19	1
18	20	1
19	21	1
20	22	1
21	23	1
22	24	1
23	27	1
24	29	1
25	30	1
26	31	1
27	32	1
28	33	1
29	34	1
30	35	1
31	36	1
32	37	1
33	38	1
34	39	1
35	40	1
36	41	1
37	42	1
38	43	1
39	44	1
40	45	1
41	46	1
42	47	1
43	48	1
44	49	1
45	50	1
46	51	1
47	52	1
48	53	1
49	54	1
50	55	1
51	56	1
52	57	1
53	58	1
54	59	1
55	60	1
56	61	1
57	62	1
58	63	1
59	64	1
60	65	1
61	66	1
62	67	1
63	69	1
64	70	1
65	71	1
66	72	1
67	73	1
68	74	1
69	75	1
70	76	1
71	77	1
72	80	1
73	82	1
74	83	1
75	84	1
76	85	1
77	86	1
78	87	1
79	88	1
80	89	1
81	90	1
82	91	1
83	92	1
84	93	1
85	94	1
86	95	1
87	96	1
88	97	1
89	98	1
90	99	1
91	100	1
92	101	1
93	102	1
94	103	1
95	104	1
96	105	1
97	106	1
98	107	1
99	108	1
100	109	1
101	110	1
102	111	1
103	112	1
104	113	1
105	114	1
106	115	1
107	116	1
108	117	1
109	118	1
110	119	1
111	120	1
112	121	1
113	123	1
114	124	1
115	125	1
116	126	1
117	127	1
118	128	1
119	129	1
120	130	1
121	131	1
122	132	1
123	133	1
124	134	1
125	135	1
126	136	1
127	137	1
128	138	1
129	139	1
130	140	1
131	141	1
132	144	1
133	145	1
134	146	1
135	147	1
136	148	1
137	149	1
138	150	1
139	151	1
140	152	1
141	153	1
142	154	1
143	156	1
144	1	2
145	2	2
146	3	2
147	5	2
148	6	2
149	7	2
150	8	2
151	9	2
152	12	2
153	13	2
154	14	2
155	15	2
156	16	2
157	17	2
158	18	2
159	19	2
160	20	2
161	21	2
162	22	2
163	23	2
164	24	2
165	25	2
166	26	2
167	28	2
168	29	2
169	31	2
170	32	2
171	33	2
172	34	2
173	35	2
174	36	2
175	37	2
176	38	2
177	39	2
178	40	2
179	41	2
180	42	2
181	43	2
182	44	2
183	45	2
184	46	2
185	47	2
186	48	2
187	49	2
188	50	2
189	51	2
190	52	2
191	53	2
192	54	2
193	55	2
194	56	2
195	57	2
196	58	2
197	59	2
198	60	2
199	61	2
200	62	2
201	63	2
202	64	2
203	65	2
204	66	2
205	67	2
206	68	2
207	69	2
208	70	2
209	71	2
210	72	2
211	73	2
212	74	2
213	75	2
214	76	2
215	77	2
216	78	2
217	79	2
218	81	2
219	82	2
220	84	2
221	85	2
222	86	2
223	87	2
224	88	2
225	89	2
226	90	2
227	91	2
228	92	2
229	93	2
230	94	2
231	95	2
232	96	2
233	97	2
234	98	2
235	99	2
236	100	2
237	101	2
238	102	2
239	103	2
240	104	2
241	105	2
242	106	2
243	107	2
244	108	2
245	109	2
246	110	2
247	111	2
248	112	2
249	113	2
250	114	2
251	115	2
252	116	2
253	117	2
254	118	2
255	119	2
256	120	2
257	121	2
258	122	2
259	123	2
260	124	2
261	125	2
262	126	2
263	127	2
264	128	2
265	129	2
266	130	2
267	131	2
268	132	2
269	133	2
270	134	2
271	135	2
272	136	2
273	137	2
274	138	2
275	139	2
276	140	2
277	141	2
278	142	2
279	143	2
280	144	2
281	145	2
282	146	2
283	147	2
284	148	2
285	149	2
286	150	2
287	151	2
288	152	2
289	153	2
290	154	2
291	155	2
292	156	2
293	2	3
294	7	3
295	8	3
296	9	3
297	10	3
298	11	3
299	12	3
300	13	3
301	20	3
302	33	3
303	50	3
304	52	3
305	53	3
306	54	3
307	55	3
308	56	3
309	57	3
310	58	3
311	66	3
312	73	3
313	86	3
314	104	3
315	106	3
316	107	3
317	108	3
318	109	3
319	110	3
320	111	3
321	112	3
322	120	3
323	1	4
324	2	4
325	3	4
326	4	4
327	5	4
328	6	4
329	7	4
330	8	4
331	9	4
332	12	4
333	13	4
334	14	4
335	15	4
336	16	4
337	20	4
338	21	4
339	22	4
340	23	4
341	24	4
342	27	4
343	28	4
344	29	4
345	30	4
346	31	4
347	32	4
348	33	4
349	34	4
350	35	4
351	36	4
352	37	4
353	38	4
354	39	4
355	41	4
356	42	4
357	43	4
358	44	4
359	45	4
360	46	4
361	47	4
362	48	4
363	49	4
364	50	4
365	51	4
366	52	4
367	53	4
368	54	4
369	55	4
370	56	4
371	57	4
372	58	4
373	60	4
374	61	4
375	62	4
376	63	4
377	64	4
378	65	4
379	66	4
380	67	4
381	68	4
382	69	4
383	73	4
384	74	4
385	75	4
386	76	4
387	77	4
388	80	4
389	81	4
390	82	4
391	83	4
392	84	4
393	85	4
394	86	4
395	87	4
396	88	4
397	89	4
398	93	4
399	95	4
400	96	4
401	97	4
402	98	4
403	99	4
404	100	4
405	101	4
406	102	4
407	103	4
408	104	4
409	105	4
410	106	4
411	107	4
412	108	4
413	109	4
414	110	4
415	111	4
416	112	4
417	114	4
418	115	4
419	116	4
420	117	4
421	118	4
422	119	4
423	120	4
424	121	4
425	122	4
426	123	4
427	125	4
428	128	4
429	129	4
430	130	4
431	131	4
432	132	4
433	134	4
434	135	4
435	137	4
436	138	4
437	139	4
438	141	4
439	144	4
440	145	4
441	146	4
442	151	4
443	153	4
444	154	4
\.


--
-- Data for Name: filters; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.filters (id, name, filter_group_id, deal_type) FROM stdin;
1	new_building	1	\N
2	area	1	\N
3	number_of_floors_of_the_building	1	\N
4	apartment_floor	1	\N
5	number_of_rooms	1	\N
6	number_of_bathrooms	1	\N
7	gas	2	\N
8	electricity	2	\N
9	permanent_water	2	\N
10	irrigation	2	\N
11	drainage	2	\N
12	sewage	2	\N
13	trash_collection	2	\N
14	cable_tv	2	\N
15	internet	2	\N
16	phone_service	2	\N
17	sauna	3	sell
18	hot_tub	3	sell
19	pool	3	sell
20	garage	3	sell
21	attic	3	sell
22	basement	3	sell
23	storage_room	3	sell
24	backyard	3	sell
25	outdoor_dining_area	3	sell
26	outdoor_kitchen	3	sell
27	high_first_floor	3	sell
28	single_level_home	3	sell
29	wheelchair_accessible	3	sell
30	elevator	3	sell
31	new_wiring	3	sell
32	new_water_tubes	3	sell
33	sunny	3	sell
34	closed_balcony	3	sell
35	open_balcony	3	sell
36	hot_water	3	sell
37	kitchen_furniture	3	sell
38	furnished	3	sell
39	heating	4	sell
40	fireplace	4	sell
41	air_conditioner	4	sell
42	turbo_charger	4	sell
43	heating_floor	4	sell
44	portable_fans	4	sell
45	ceiling_fan	4	sell
46	security_system	5	sell
47	smoke_alarm	5	sell
48	fire_extinguisher	5	sell
49	carbon_monoxide_detector	5	sell
50	roadside	6	sell
51	private_entrance	6	sell
52	waterfront	6	sell
53	playground	6	sell
54	park	6	sell
55	near_the_bus_stop	6	sell
56	petrol_station	6	sell
57	gym	6	sell
58	parking	6	sell
59	carpet	7	sell
60	vinyl	7	sell
61	tile	7	sell
62	hardwood	7	sell
63	laminate	7	sell
64	grills	7	sell
65	iron_door	7	sell
66	fence	7	sell
67	parquet	7	sell
68	gate	7	sell
69	euro_windows	7	sell
70	sauna	3	rent
71	hot_tub	3	rent
72	pool	3	rent
73	garage	3	rent
74	attic	3	rent
75	basement	3	rent
76	storage_room	3	rent
77	backyard	3	rent
78	outdoor_dining_area	3	rent
79	outdoor_kitchen	3	rent
80	high_first_floor	3	rent
81	single_level_home	3	rent
82	wheelchair_accessible	3	rent
83	elevator	3	rent
84	new_wiring	3	rent
85	new_water_tubes	3	rent
86	sunny	3	rent
87	closed_balcony	3	rent
88	open_balcony	3	rent
89	hot_water	3	rent
90	toiletries	3	rent
91	bed_linen	3	rent
92	cleaning_products	3	rent
93	heating	4	rent
94	fireplace	4	rent
95	air_conditioner	4	rent
96	turbo_charger	4	rent
97	heating_floor	4	rent
98	portable_fans	4	rent
99	ceiling_fan	4	rent
100	security_system	5	rent
101	smoke_alarm	5	rent
102	fire_extinguisher	5	rent
103	carbon_monoxide_detector	5	rent
104	roadside	6	rent
105	private_entrance	6	rent
106	waterfront	6	rent
107	playground	6	rent
108	park	6	rent
109	near_the_bus_stop	6	rent
110	petrol_station	6	rent
111	gym	6	rent
112	parking	6	rent
113	carpet	7	rent
114	vinyl	7	rent
115	tile	7	rent
116	hardwood	7	rent
117	laminate	7	rent
118	grills	7	rent
119	iron_door	7	rent
120	fence	7	rent
121	parquet	7	rent
122	gate	7	rent
123	euro_windows	7	rent
124	washer	8	rent
125	dishwasher	8	rent
126	dryer	8	rent
127	drying rack	8	rent
128	fridge	8	rent
129	mini_fridge	8	rent
130	freezer	8	rent
131	microwave	8	rent
132	stove	8	rent
133	oven	8	rent
134	rangehood	8	rent
135	kettle	8	rent
136	bread_maker	8	rent
137	coffee_maker	8	rent
138	blender	8	rent
139	toaster	8	rent
140	mixer	8	rent
141	kitchenware	8	rent
142	cooking_basics	8	rent
143	firepit	8	sell
144	tV	8	rent
145	speaker	8	rent
146	air_purifier	8	rent
147	vacuum_cleaner	8	rent
148	hairdryer	8	rent
149	iron_board	8	rent
150	living_room_furniture	9	rent
151	kitchen_furniture	9	rent
152	bedroom_furniture	9	rent
153	office_furniture	9	rent
154	fitness_equipment	9	rent
155	outdoor_furniture	9	rent
156	crib	9	rent
\.


--
-- Data for Name: filters_values; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.filters_values (id, filter_id, property_id, value) FROM stdin;
\.


--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- Data for Name: languages; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.languages (id, name, code, flag_image) FROM stdin;
1	Armenia	hy	https://travelarmenia.org/wp-content/uploads/2015/12/Armenia-Flag-10.jpg
2	English	en	https://travelarmenia.org/wp-content/uploads/2015/12/Armenia-Flag-10.jpg
3	Russia	ru	https://travelarmenia.org/wp-content/uploads/2015/12/Armenia-Flag-10.jpg
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
139	2014_08_31_045225_create_user_types_table	2
140	2014_08_31_053010_create_users_table	2
141	2014_10_12_100000_create_password_resets_table	2
142	2016_06_01_000001_create_oauth_auth_codes_table	2
143	2016_06_01_000002_create_oauth_access_tokens_table	2
144	2016_06_01_000003_create_oauth_refresh_tokens_table	2
145	2016_06_01_000004_create_oauth_clients_table	2
146	2016_06_01_000005_create_oauth_personal_access_clients_table	2
147	2019_08_19_000000_create_failed_jobs_table	2
10	2019_11_19_000000_update_social_provider_users_table	1
148	2020_08_31_055915_create_phones_table	2
149	2020_08_31_063110_create_languages_table	2
150	2020_08_31_063704_create_translations_table	2
151	2020_08_31_070203_create_property_types_table	2
152	2020_08_31_070543_create_deal_types_table	2
153	2020_08_31_070742_create_bulding_types_table	2
154	2020_08_31_071835_create_properties_table	2
155	2020_08_31_073443_create_filter_groups_table	2
156	2020_08_31_074326_create_filters_table	2
157	2020_08_31_075133_create_filters_values_table	2
158	2020_09_03_081033_add_is_admin_to_users	2
159	2020_09_03_082417_create_property_images_table	2
160	2020_09_10_054540_create_filter_property_types_table	2
161	2020_09_10_062703_create_currency_types_table	2
162	2020_09_16_123337_create_translate_descriptions_table	2
163	2020_09_23_133823_create_user_favorite_properties_table	2
164	2020_12_07_055028_create_property_deals_table	2
165	2020_12_16_111325_add_rate_to_currency_types_table	2
166	2021_01_12_054335_create_save_user_filters_table	2
167	2021_05_12_122048_add_block_to_users_table	2
168	2021_07_15_071012_create_jobs_table	2
179	2021_12_17_094357_add_last_update_and_next_update_and_is_bids_and_is_archive_to_properties_table	3
169	2021_07_15_110835_create_notification_users_properties_table	2
170	2021_07_30_082330_create_supports_table	2
171	2021_10_20_110358_add_last_active_time_to_users_table	2
172	2021_10_21_080351_add_email_to_properties_table	2
173	2021_10_21_090943_create_suggests_price_properties_table	2
174	2021_11_22_112905_create_property_client_ips_table	2
175	2021_11_22_122806_add_view_to_properties_table	2
176	2021_11_30_073755_add_is_address_precise_to_properties	2
177	2021_12_09_130208_add_subgroup_id_and_deal_type_id_to_filters	2
178	2021_12_14_061354_change_name_unique_to_filters_table	2
\.


--
-- Data for Name: notification_users_properties; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.notification_users_properties (id, user_id, property_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: oauth_access_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.oauth_access_tokens (id, user_id, client_id, name, scopes, revoked, created_at, updated_at, expires_at) FROM stdin;
218eb22dded888d23365f9c11bf06502953fc18963b80487b02815dd633b34b7d016f84f285da92f	1	2	\N	[]	f	2021-12-15 13:35:19	2021-12-15 13:35:19	2022-12-15 13:35:19
14201695fdb3af01e81bf4adc31bf7d44db19e8790333733328ce3bf715b2e1fb3bd7a0464289606	1	2	\N	[]	f	2021-12-15 13:39:29	2021-12-15 13:39:29	2022-12-15 13:39:29
9fcd6be5c840da5fb8a4ce7353c43151c5a5f96e807e3755ee5b9590f73cbbc40a2dd92ff2b0bc3b	1	2	\N	[]	f	2021-12-16 08:36:54	2021-12-16 08:36:54	2022-12-16 08:36:54
12026cc5d9726b11347b089b34d504893e09c4b19c8a61058f2a895d209aaed1dd5a97156648b242	1	2	\N	[]	f	2021-12-17 13:38:53	2021-12-17 13:38:53	2022-12-17 13:38:53
3fa4f7a6d02a37aa98e8fafdd8e505aa518f438738d1e092c29f6d764d4fc9eb30305b6096c284cb	1	2	\N	[]	f	2021-12-20 06:56:46	2021-12-20 06:56:46	2022-12-20 06:56:46
43e9da90c3ac88ba443a5026ed57ec4c88289a424f1c8c02ee93f601d1282e1e7d92755b82468f2a	1	2	\N	[]	f	2021-12-20 07:04:59	2021-12-20 07:04:59	2022-12-20 07:04:59
\.


--
-- Data for Name: oauth_auth_codes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.oauth_auth_codes (id, user_id, client_id, scopes, revoked, expires_at) FROM stdin;
\.


--
-- Data for Name: oauth_clients; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.oauth_clients (id, user_id, name, secret, provider, redirect, personal_access_client, password_client, revoked, created_at, updated_at) FROM stdin;
1	\N	Estate Personal Access Client	s9ljTOnQqgVJ9W1iDuJtwDjeynV48bwbjioCcLvp	\N	http://localhost	t	f	f	2021-12-15 13:23:48	2021-12-15 13:23:48
2	\N	Estate Password Grant Client	UBArTT4kKuNgOAPf42hG0JkPos1jBQ4rkAxiMp85	users	http://localhost	f	t	f	2021-12-15 13:23:48	2021-12-15 13:23:48
\.


--
-- Data for Name: oauth_personal_access_clients; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.oauth_personal_access_clients (id, client_id, created_at, updated_at) FROM stdin;
1	1	2021-12-15 13:23:48	2021-12-15 13:23:48
\.


--
-- Data for Name: oauth_refresh_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.oauth_refresh_tokens (id, access_token_id, revoked, expires_at) FROM stdin;
b3a5312a7bd28623d09005a004c3aba62cf7c090d7c2cbae36aba857a9bccfe61eea4cb6cdd9f90b	218eb22dded888d23365f9c11bf06502953fc18963b80487b02815dd633b34b7d016f84f285da92f	f	2022-12-15 13:35:19
34fb28da3ab2919410764409a69d25e0beab3b716e679027de353a1bb85e0e075dac6ba592e563fb	14201695fdb3af01e81bf4adc31bf7d44db19e8790333733328ce3bf715b2e1fb3bd7a0464289606	f	2022-12-15 13:39:29
e08841055d65f8385546ada382bc5480c56680fc3e31d6b2ce2943c5f14af0c02360b3e1f8054d2b	9fcd6be5c840da5fb8a4ce7353c43151c5a5f96e807e3755ee5b9590f73cbbc40a2dd92ff2b0bc3b	f	2022-12-16 08:36:54
9b5f65212d8897d243cac98e048c7f14df9921845d3d058d21ce2b6ded70c1f6c7ab2295afd5b07e	12026cc5d9726b11347b089b34d504893e09c4b19c8a61058f2a895d209aaed1dd5a97156648b242	f	2022-12-17 13:38:53
87e91532a35abc059e0b917a16a31d5f49eb9e1278cfcacfdaf30739f4d9396df605e39abe889012	3fa4f7a6d02a37aa98e8fafdd8e505aa518f438738d1e092c29f6d764d4fc9eb30305b6096c284cb	f	2022-12-20 06:56:46
2d64a1c6509c8e0cb8a09a437f4dd73879b318b76dc8e95eb419f838c2b849f07725e493fd5b39ed	43e9da90c3ac88ba443a5026ed57ec4c88289a424f1c8c02ee93f601d1282e1e7d92755b82468f2a	f	2022-12-20 07:04:59
\.


--
-- Data for Name: password_resets; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.password_resets (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: phones; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.phones (id, number, viber, whatsapp, telegram, user_id) FROM stdin;
1	(972) 693-7981 x1769	f	f	f	1
2	(361) 734-8305	f	f	f	1
\.


--
-- Data for Name: properties; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.properties (id, property_key, property_type_id, user_id, bulding_type_id, latitude, longitude, address, postal_code, property_state, review, is_public_status, is_save, is_delete, created_at, updated_at, email, view, is_address_precise, update_count, next_update, last_update, is_archive, is_bids) FROM stdin;
\.


--
-- Data for Name: property_client_ips; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.property_client_ips (id, property_id, client_ip, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: property_deals; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.property_deals (id, property_id, deal_type_id, price, currency_type_id) FROM stdin;
\.


--
-- Data for Name: property_images; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.property_images (id, property_id, name, index, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: property_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.property_types (id, name) FROM stdin;
1	apartment
2	mansion
3	land_area
4	commercial_area
\.


--
-- Data for Name: save_user_filters; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.save_user_filters (id, properties_filters, user_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: suggests_price_properties; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.suggests_price_properties (id, user_id, property_id, price, currency_type_id, end_time, is_checked, is_delete, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: supports; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.supports (id, user_id, name, email, text, is_support_status, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: translate_descriptions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.translate_descriptions (id, property_id, language_id, description) FROM stdin;
\.


--
-- Data for Name: translations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.translations (id, name, translated_name, language_id) FROM stdin;
\.


--
-- Data for Name: user_favorite_properties; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.user_favorite_properties (id, user_id, property_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: user_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.user_types (id, name) FROM stdin;
1	individual
2	agency
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, full_name, picture, email, user_type_id, email_verified_at, password, provider, provider_id, remember_token, first_time, is_admin, is_delete, is_block, block_start, block_end, created_at, updated_at, reason, last_active_time) FROM stdin;
1	Mihran Baldryan		mihran.baldryan@gmail.com	2	2021-12-15 13:35:02	$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi	\N	\N	FwtKYaCECC	2021-12-20	t	f	f	\N	\N	2021-12-15 13:35:02	2021-12-20 07:04:59	\N	\N
\.


--
-- Name: bulding_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.bulding_types_id_seq', 10, true);


--
-- Name: currency_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.currency_types_id_seq', 3, true);


--
-- Name: deal_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.deal_types_id_seq', 3, true);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: filter_groups_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.filter_groups_id_seq', 9, true);


--
-- Name: filter_property_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.filter_property_types_id_seq', 444, true);


--
-- Name: filters_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.filters_id_seq', 156, true);


--
-- Name: filters_values_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.filters_values_id_seq', 60, true);


--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- Name: languages_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.languages_id_seq', 3, true);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 179, true);


--
-- Name: notification_users_properties_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.notification_users_properties_id_seq', 1, false);


--
-- Name: oauth_clients_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.oauth_clients_id_seq', 2, true);


--
-- Name: oauth_personal_access_clients_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.oauth_personal_access_clients_id_seq', 1, true);


--
-- Name: phones_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.phones_id_seq', 2, true);


--
-- Name: properties_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.properties_id_seq', 2, true);


--
-- Name: property_client_ips_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.property_client_ips_id_seq', 1, false);


--
-- Name: property_deals_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.property_deals_id_seq', 4, true);


--
-- Name: property_images_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.property_images_id_seq', 1, false);


--
-- Name: property_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.property_types_id_seq', 4, true);


--
-- Name: save_user_filters_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.save_user_filters_id_seq', 1, false);


--
-- Name: suggests_price_properties_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.suggests_price_properties_id_seq', 1, false);


--
-- Name: supports_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.supports_id_seq', 1, false);


--
-- Name: translate_descriptions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.translate_descriptions_id_seq', 1, false);


--
-- Name: translations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.translations_id_seq', 1, false);


--
-- Name: user_favorite_properties_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.user_favorite_properties_id_seq', 1, false);


--
-- Name: user_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.user_types_id_seq', 2, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 1, true);


--
-- Name: bulding_types bulding_types_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bulding_types
    ADD CONSTRAINT bulding_types_name_unique UNIQUE (name);


--
-- Name: bulding_types bulding_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bulding_types
    ADD CONSTRAINT bulding_types_pkey PRIMARY KEY (id);


--
-- Name: currency_types currency_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.currency_types
    ADD CONSTRAINT currency_types_pkey PRIMARY KEY (id);


--
-- Name: deal_types deal_types_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.deal_types
    ADD CONSTRAINT deal_types_name_unique UNIQUE (name);


--
-- Name: deal_types deal_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.deal_types
    ADD CONSTRAINT deal_types_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: filter_groups filter_groups_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.filter_groups
    ADD CONSTRAINT filter_groups_pkey PRIMARY KEY (id);


--
-- Name: filter_property_types filter_property_types_filter_id_property_type_id_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.filter_property_types
    ADD CONSTRAINT filter_property_types_filter_id_property_type_id_unique UNIQUE (filter_id, property_type_id);


--
-- Name: filter_property_types filter_property_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.filter_property_types
    ADD CONSTRAINT filter_property_types_pkey PRIMARY KEY (id);


--
-- Name: filters filters_name_deal_type_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.filters
    ADD CONSTRAINT filters_name_deal_type_unique UNIQUE (name, deal_type);


--
-- Name: filters filters_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.filters
    ADD CONSTRAINT filters_pkey PRIMARY KEY (id);


--
-- Name: filters_values filters_values_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.filters_values
    ADD CONSTRAINT filters_values_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: languages languages_code_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.languages
    ADD CONSTRAINT languages_code_unique UNIQUE (code);


--
-- Name: languages languages_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.languages
    ADD CONSTRAINT languages_name_unique UNIQUE (name);


--
-- Name: languages languages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.languages
    ADD CONSTRAINT languages_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: notification_users_properties notification_users_properties_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notification_users_properties
    ADD CONSTRAINT notification_users_properties_pkey PRIMARY KEY (id);


--
-- Name: oauth_access_tokens oauth_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.oauth_access_tokens
    ADD CONSTRAINT oauth_access_tokens_pkey PRIMARY KEY (id);


--
-- Name: oauth_auth_codes oauth_auth_codes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.oauth_auth_codes
    ADD CONSTRAINT oauth_auth_codes_pkey PRIMARY KEY (id);


--
-- Name: oauth_clients oauth_clients_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.oauth_clients
    ADD CONSTRAINT oauth_clients_pkey PRIMARY KEY (id);


--
-- Name: oauth_personal_access_clients oauth_personal_access_clients_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.oauth_personal_access_clients
    ADD CONSTRAINT oauth_personal_access_clients_pkey PRIMARY KEY (id);


--
-- Name: oauth_refresh_tokens oauth_refresh_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.oauth_refresh_tokens
    ADD CONSTRAINT oauth_refresh_tokens_pkey PRIMARY KEY (id);


--
-- Name: phones phones_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.phones
    ADD CONSTRAINT phones_pkey PRIMARY KEY (id);


--
-- Name: properties properties_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.properties
    ADD CONSTRAINT properties_pkey PRIMARY KEY (id);


--
-- Name: property_client_ips property_client_ips_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.property_client_ips
    ADD CONSTRAINT property_client_ips_pkey PRIMARY KEY (id);


--
-- Name: property_deals property_deals_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.property_deals
    ADD CONSTRAINT property_deals_pkey PRIMARY KEY (id);


--
-- Name: property_images property_images_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.property_images
    ADD CONSTRAINT property_images_pkey PRIMARY KEY (id);


--
-- Name: property_types property_types_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.property_types
    ADD CONSTRAINT property_types_name_unique UNIQUE (name);


--
-- Name: property_types property_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.property_types
    ADD CONSTRAINT property_types_pkey PRIMARY KEY (id);


--
-- Name: save_user_filters save_user_filters_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.save_user_filters
    ADD CONSTRAINT save_user_filters_pkey PRIMARY KEY (id);


--
-- Name: suggests_price_properties suggests_price_properties_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.suggests_price_properties
    ADD CONSTRAINT suggests_price_properties_pkey PRIMARY KEY (id);


--
-- Name: supports supports_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.supports
    ADD CONSTRAINT supports_pkey PRIMARY KEY (id);


--
-- Name: translate_descriptions translate_descriptions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.translate_descriptions
    ADD CONSTRAINT translate_descriptions_pkey PRIMARY KEY (id);


--
-- Name: translations translations_name_language_id_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.translations
    ADD CONSTRAINT translations_name_language_id_unique UNIQUE (name, language_id);


--
-- Name: translations translations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.translations
    ADD CONSTRAINT translations_pkey PRIMARY KEY (id);


--
-- Name: user_favorite_properties user_favorite_properties_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_favorite_properties
    ADD CONSTRAINT user_favorite_properties_pkey PRIMARY KEY (id);


--
-- Name: user_types user_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_types
    ADD CONSTRAINT user_types_pkey PRIMARY KEY (id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: oauth_access_tokens_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX oauth_access_tokens_user_id_index ON public.oauth_access_tokens USING btree (user_id);


--
-- Name: oauth_auth_codes_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX oauth_auth_codes_user_id_index ON public.oauth_auth_codes USING btree (user_id);


--
-- Name: oauth_clients_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX oauth_clients_user_id_index ON public.oauth_clients USING btree (user_id);


--
-- Name: oauth_refresh_tokens_access_token_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX oauth_refresh_tokens_access_token_id_index ON public.oauth_refresh_tokens USING btree (access_token_id);


--
-- Name: password_resets_email_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX password_resets_email_index ON public.password_resets USING btree (email);


--
-- Name: filter_property_types filter_property_types_filter_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.filter_property_types
    ADD CONSTRAINT filter_property_types_filter_id_foreign FOREIGN KEY (filter_id) REFERENCES public.filters(id) ON DELETE CASCADE;


--
-- Name: filter_property_types filter_property_types_property_type_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.filter_property_types
    ADD CONSTRAINT filter_property_types_property_type_id_foreign FOREIGN KEY (property_type_id) REFERENCES public.property_types(id) ON DELETE CASCADE;


--
-- Name: filters filters_filter_group_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.filters
    ADD CONSTRAINT filters_filter_group_id_foreign FOREIGN KEY (filter_group_id) REFERENCES public.filter_groups(id) ON DELETE CASCADE;


--
-- Name: filters_values filters_values_filter_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.filters_values
    ADD CONSTRAINT filters_values_filter_id_foreign FOREIGN KEY (filter_id) REFERENCES public.filters(id) ON DELETE CASCADE;


--
-- Name: filters_values filters_values_property_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.filters_values
    ADD CONSTRAINT filters_values_property_id_foreign FOREIGN KEY (property_id) REFERENCES public.properties(id) ON DELETE CASCADE;


--
-- Name: notification_users_properties notification_users_properties_property_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notification_users_properties
    ADD CONSTRAINT notification_users_properties_property_id_foreign FOREIGN KEY (property_id) REFERENCES public.properties(id) ON DELETE CASCADE;


--
-- Name: notification_users_properties notification_users_properties_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notification_users_properties
    ADD CONSTRAINT notification_users_properties_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: phones phones_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.phones
    ADD CONSTRAINT phones_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: properties properties_bulding_type_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.properties
    ADD CONSTRAINT properties_bulding_type_id_foreign FOREIGN KEY (bulding_type_id) REFERENCES public.bulding_types(id) ON DELETE CASCADE;


--
-- Name: properties properties_property_type_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.properties
    ADD CONSTRAINT properties_property_type_id_foreign FOREIGN KEY (property_type_id) REFERENCES public.property_types(id) ON DELETE CASCADE;


--
-- Name: properties properties_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.properties
    ADD CONSTRAINT properties_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: property_client_ips property_client_ips_property_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.property_client_ips
    ADD CONSTRAINT property_client_ips_property_id_foreign FOREIGN KEY (property_id) REFERENCES public.properties(id) ON DELETE CASCADE;


--
-- Name: property_deals property_deals_currency_type_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.property_deals
    ADD CONSTRAINT property_deals_currency_type_id_foreign FOREIGN KEY (currency_type_id) REFERENCES public.currency_types(id) ON DELETE CASCADE;


--
-- Name: property_deals property_deals_deal_type_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.property_deals
    ADD CONSTRAINT property_deals_deal_type_id_foreign FOREIGN KEY (deal_type_id) REFERENCES public.deal_types(id) ON DELETE CASCADE;


--
-- Name: property_deals property_deals_property_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.property_deals
    ADD CONSTRAINT property_deals_property_id_foreign FOREIGN KEY (property_id) REFERENCES public.properties(id) ON DELETE CASCADE;


--
-- Name: property_images property_images_property_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.property_images
    ADD CONSTRAINT property_images_property_id_foreign FOREIGN KEY (property_id) REFERENCES public.properties(id) ON DELETE CASCADE;


--
-- Name: save_user_filters save_user_filters_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.save_user_filters
    ADD CONSTRAINT save_user_filters_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: suggests_price_properties suggests_price_properties_currency_type_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.suggests_price_properties
    ADD CONSTRAINT suggests_price_properties_currency_type_id_foreign FOREIGN KEY (currency_type_id) REFERENCES public.currency_types(id) ON DELETE CASCADE;


--
-- Name: suggests_price_properties suggests_price_properties_property_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.suggests_price_properties
    ADD CONSTRAINT suggests_price_properties_property_id_foreign FOREIGN KEY (property_id) REFERENCES public.properties(id) ON DELETE CASCADE;


--
-- Name: suggests_price_properties suggests_price_properties_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.suggests_price_properties
    ADD CONSTRAINT suggests_price_properties_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: supports supports_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.supports
    ADD CONSTRAINT supports_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: translate_descriptions translate_descriptions_language_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.translate_descriptions
    ADD CONSTRAINT translate_descriptions_language_id_foreign FOREIGN KEY (language_id) REFERENCES public.languages(id) ON DELETE CASCADE;


--
-- Name: translate_descriptions translate_descriptions_property_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.translate_descriptions
    ADD CONSTRAINT translate_descriptions_property_id_foreign FOREIGN KEY (property_id) REFERENCES public.properties(id) ON DELETE CASCADE;


--
-- Name: translations translations_language_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.translations
    ADD CONSTRAINT translations_language_id_foreign FOREIGN KEY (language_id) REFERENCES public.languages(id) ON DELETE CASCADE;


--
-- Name: user_favorite_properties user_favorite_properties_property_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_favorite_properties
    ADD CONSTRAINT user_favorite_properties_property_id_foreign FOREIGN KEY (property_id) REFERENCES public.properties(id) ON DELETE CASCADE;


--
-- Name: user_favorite_properties user_favorite_properties_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_favorite_properties
    ADD CONSTRAINT user_favorite_properties_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: users users_user_type_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_user_type_id_foreign FOREIGN KEY (user_type_id) REFERENCES public.user_types(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

