--
-- PostgreSQL database dump
--

-- Dumped from database version 12.22 (Ubuntu 12.22-0ubuntu0.20.04.4)
-- Dumped by pg_dump version 12.22 (Ubuntu 12.22-0ubuntu0.20.04.4)

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
-- Name: cache; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache OWNER TO postgres;

--
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache_locks OWNER TO postgres;

--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
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
-- Name: job_batches; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


ALTER TABLE public.job_batches OWNER TO postgres;

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
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO postgres;

--
-- Name: sessions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


ALTER TABLE public.sessions OWNER TO postgres;

--
-- Name: tbl_dimensi_mutu; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_dimensi_mutu (
    id bigint NOT NULL,
    nama_dimensi_mutu character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.tbl_dimensi_mutu OWNER TO postgres;

--
-- Name: tbl_dimensi_mutu_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_dimensi_mutu_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_dimensi_mutu_id_seq OWNER TO postgres;

--
-- Name: tbl_dimensi_mutu_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_dimensi_mutu_id_seq OWNED BY public.tbl_dimensi_mutu.id;


--
-- Name: tbl_hak_akses; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_hak_akses (
    id bigint NOT NULL,
    role_id integer NOT NULL,
    menu_key character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.tbl_hak_akses OWNER TO postgres;

--
-- Name: tbl_hak_akses_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_hak_akses_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_hak_akses_id_seq OWNER TO postgres;

--
-- Name: tbl_hak_akses_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_hak_akses_id_seq OWNED BY public.tbl_hak_akses.id;


--
-- Name: tbl_hasil_analisa; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_hasil_analisa (
    id bigint NOT NULL,
    indikator_id integer NOT NULL,
    tanggal_analisa date NOT NULL,
    analisa text,
    tindak_lanjut text,
    unit_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.tbl_hasil_analisa OWNER TO postgres;

--
-- Name: tbl_hasil_analisa_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_hasil_analisa_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_hasil_analisa_id_seq OWNER TO postgres;

--
-- Name: tbl_hasil_analisa_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_hasil_analisa_id_seq OWNED BY public.tbl_hasil_analisa.id;


--
-- Name: tbl_indikator; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_indikator (
    id bigint NOT NULL,
    nama_indikator character varying(255) NOT NULL,
    target_indikator numeric(5,2),
    target_min numeric(8,2),
    target_max numeric(8,2),
    arah_target character varying(255) DEFAULT 'lebih_besar'::character varying NOT NULL,
    status_indikator character varying(255) NOT NULL,
    unit_id integer NOT NULL,
    kamus_indikator_id integer,
    keterangan text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT tbl_indikator_arah_target_check CHECK (((arah_target)::text = ANY (ARRAY[('lebih_besar'::character varying)::text, ('lebih_kecil'::character varying)::text, ('range'::character varying)::text]))),
    CONSTRAINT tbl_indikator_status_indikator_check CHECK (((status_indikator)::text = ANY (ARRAY[('aktif'::character varying)::text, ('non-aktif'::character varying)::text])))
);


ALTER TABLE public.tbl_indikator OWNER TO postgres;

--
-- Name: tbl_indikator_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_indikator_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_indikator_id_seq OWNER TO postgres;

--
-- Name: tbl_indikator_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_indikator_id_seq OWNED BY public.tbl_indikator.id;


--
-- Name: tbl_indikator_periode; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_indikator_periode (
    id bigint NOT NULL,
    indikator_id integer NOT NULL,
    periode_id integer NOT NULL,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT tbl_indikator_periode_status_check CHECK (((status)::text = ANY (ARRAY[('aktif'::character varying)::text, ('non-aktif'::character varying)::text])))
);


ALTER TABLE public.tbl_indikator_periode OWNER TO postgres;

--
-- Name: tbl_indikator_periode_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_indikator_periode_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_indikator_periode_id_seq OWNER TO postgres;

--
-- Name: tbl_indikator_periode_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_indikator_periode_id_seq OWNED BY public.tbl_indikator_periode.id;


--
-- Name: tbl_jenis_indikator; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_jenis_indikator (
    id bigint NOT NULL,
    nama_jenis_indikator character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.tbl_jenis_indikator OWNER TO postgres;

--
-- Name: tbl_jenis_indikator_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_jenis_indikator_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_jenis_indikator_id_seq OWNER TO postgres;

--
-- Name: tbl_jenis_indikator_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_jenis_indikator_id_seq OWNED BY public.tbl_jenis_indikator.id;


--
-- Name: tbl_kamus_indikator; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_kamus_indikator (
    id bigint NOT NULL,
    indikator_id integer NOT NULL,
    kategori_indikator character varying(255) NOT NULL,
    kategori_id integer,
    dimensi_mutu_id character varying(255) NOT NULL,
    dasar_pemikiran text NOT NULL,
    tujuan text NOT NULL,
    definisi_operasional text NOT NULL,
    jenis_indikator_id integer NOT NULL,
    satuan_pengukuran text NOT NULL,
    numerator text NOT NULL,
    denominator text NOT NULL,
    target_pencapaian text NOT NULL,
    kriteria_inklusi text NOT NULL,
    kriteria_eksklusi text NOT NULL,
    formula text NOT NULL,
    metode_pengumpulan_data text NOT NULL,
    sumber_data text NOT NULL,
    instrumen_pengambilan_data text NOT NULL,
    populasi text NOT NULL,
    sampel text NOT NULL,
    periode_pengumpulan_data_id integer NOT NULL,
    periode_analisis_data_id integer NOT NULL,
    penyajian_data_id integer NOT NULL,
    penanggung_jawab text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.tbl_kamus_indikator OWNER TO postgres;

--
-- Name: tbl_kamus_indikator_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_kamus_indikator_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_kamus_indikator_id_seq OWNER TO postgres;

--
-- Name: tbl_kamus_indikator_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_kamus_indikator_id_seq OWNED BY public.tbl_kamus_indikator.id;


--
-- Name: tbl_kategori_imprs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_kategori_imprs (
    id bigint NOT NULL,
    nama_kategori_imprs character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.tbl_kategori_imprs OWNER TO postgres;

--
-- Name: tbl_kategori_imprs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_kategori_imprs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_kategori_imprs_id_seq OWNER TO postgres;

--
-- Name: tbl_kategori_imprs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_kategori_imprs_id_seq OWNED BY public.tbl_kategori_imprs.id;


--
-- Name: tbl_laporan_dan_analis; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_laporan_dan_analis (
    id bigint NOT NULL,
    tanggal_laporan date,
    indikator_id integer NOT NULL,
    nilai_validator numeric(8,2),
    unit_id integer,
    kategori_indikator character varying(255),
    kategori_id integer,
    numerator integer,
    denominator integer,
    nilai numeric(8,2),
    pencapaian character varying(255) NOT NULL,
    status_laporan character varying(255),
    file_laporan character varying(255),
    target_saat_input numeric(8,2),
    target_min_saat_input numeric(8,2),
    target_max_saat_input numeric(8,2),
    arah_target_saat_input character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT tbl_laporan_dan_analis_arah_target_saat_input_check CHECK (((arah_target_saat_input)::text = ANY (ARRAY[('lebih_besar'::character varying)::text, ('lebih_kecil'::character varying)::text, ('range'::character varying)::text]))),
    CONSTRAINT tbl_laporan_dan_analis_pencapaian_check CHECK (((pencapaian)::text = ANY (ARRAY[('tercapai'::character varying)::text, ('tidak-tercapai'::character varying)::text, ('N/A'::character varying)::text]))),
    CONSTRAINT tbl_laporan_dan_analis_status_laporan_check CHECK (((status_laporan)::text = ANY (ARRAY[('valid'::character varying)::text, ('tidak-valid'::character varying)::text])))
);


ALTER TABLE public.tbl_laporan_dan_analis OWNER TO postgres;

--
-- Name: tbl_laporan_dan_analis_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_laporan_dan_analis_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_laporan_dan_analis_id_seq OWNER TO postgres;

--
-- Name: tbl_laporan_dan_analis_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_laporan_dan_analis_id_seq OWNED BY public.tbl_laporan_dan_analis.id;


--
-- Name: tbl_laporan_validator; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_laporan_validator (
    id bigint NOT NULL,
    tanggal_laporan date,
    indikator_id integer NOT NULL,
    laporan_analis_id integer NOT NULL,
    unit_id integer,
    kategori_indikator character varying(255),
    kategori_id integer,
    numerator integer NOT NULL,
    denominator integer NOT NULL,
    nilai_validator numeric(8,2),
    pencapaian character varying(255) NOT NULL,
    status_laporan character varying(255),
    file_laporan character varying(255),
    target_saat_input numeric(8,2),
    target_min_saat_input numeric(8,2),
    target_max_saat_input numeric(8,2),
    arah_target_saat_input character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT tbl_laporan_validator_arah_target_saat_input_check CHECK (((arah_target_saat_input)::text = ANY (ARRAY[('lebih_besar'::character varying)::text, ('lebih_kecil'::character varying)::text, ('range'::character varying)::text]))),
    CONSTRAINT tbl_laporan_validator_pencapaian_check CHECK (((pencapaian)::text = ANY (ARRAY[('tercapai'::character varying)::text, ('tidak-tercapai'::character varying)::text, ('N/A'::character varying)::text]))),
    CONSTRAINT tbl_laporan_validator_status_laporan_check CHECK (((status_laporan)::text = ANY (ARRAY[('valid'::character varying)::text, ('tidak-valid'::character varying)::text])))
);


ALTER TABLE public.tbl_laporan_validator OWNER TO postgres;

--
-- Name: tbl_laporan_validator_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_laporan_validator_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_laporan_validator_id_seq OWNER TO postgres;

--
-- Name: tbl_laporan_validator_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_laporan_validator_id_seq OWNED BY public.tbl_laporan_validator.id;


--
-- Name: tbl_metode_pengumpulan_data; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_metode_pengumpulan_data (
    id bigint NOT NULL,
    nama_metode_pengumpulan_data character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.tbl_metode_pengumpulan_data OWNER TO postgres;

--
-- Name: tbl_metode_pengumpulan_data_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_metode_pengumpulan_data_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_metode_pengumpulan_data_id_seq OWNER TO postgres;

--
-- Name: tbl_metode_pengumpulan_data_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_metode_pengumpulan_data_id_seq OWNED BY public.tbl_metode_pengumpulan_data.id;


--
-- Name: tbl_pdsa; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_pdsa (
    id bigint NOT NULL,
    assignment_id integer NOT NULL,
    plan text,
    "do" text,
    study text,
    action text,
    created_by integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.tbl_pdsa OWNER TO postgres;

--
-- Name: tbl_pdsa_assignments; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_pdsa_assignments (
    id bigint NOT NULL,
    indikator_id integer NOT NULL,
    unit_id integer NOT NULL,
    tahun integer NOT NULL,
    quarter character varying(255) NOT NULL,
    catatan_mutu text,
    status_pdsa character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT tbl_pdsa_assignments_quarter_check CHECK (((quarter)::text = ANY (ARRAY[('Q1'::character varying)::text, ('Q2'::character varying)::text, ('Q3'::character varying)::text, ('Q4'::character varying)::text]))),
    CONSTRAINT tbl_pdsa_assignments_status_pdsa_check CHECK (((status_pdsa)::text = ANY (ARRAY[('assigned'::character varying)::text, ('submitted'::character varying)::text, ('revised'::character varying)::text, ('approved'::character varying)::text])))
);


ALTER TABLE public.tbl_pdsa_assignments OWNER TO postgres;

--
-- Name: tbl_pdsa_assignments_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_pdsa_assignments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_pdsa_assignments_id_seq OWNER TO postgres;

--
-- Name: tbl_pdsa_assignments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_pdsa_assignments_id_seq OWNED BY public.tbl_pdsa_assignments.id;


--
-- Name: tbl_pdsa_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_pdsa_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_pdsa_id_seq OWNER TO postgres;

--
-- Name: tbl_pdsa_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_pdsa_id_seq OWNED BY public.tbl_pdsa.id;


--
-- Name: tbl_penyajian_data; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_penyajian_data (
    id bigint NOT NULL,
    nama_penyajian_data character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.tbl_penyajian_data OWNER TO postgres;

--
-- Name: tbl_penyajian_data_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_penyajian_data_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_penyajian_data_id_seq OWNER TO postgres;

--
-- Name: tbl_penyajian_data_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_penyajian_data_id_seq OWNED BY public.tbl_penyajian_data.id;


--
-- Name: tbl_periode; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_periode (
    id bigint NOT NULL,
    nama_periode character varying(255) NOT NULL,
    tahun integer NOT NULL,
    tanggal_mulai date NOT NULL,
    tanggal_selesai date NOT NULL,
    deadline integer,
    status_deadline boolean DEFAULT true NOT NULL,
    status character varying(255) DEFAULT 'non-aktif'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT tbl_periode_status_check CHECK (((status)::text = ANY (ARRAY[('aktif'::character varying)::text, ('non-aktif'::character varying)::text])))
);


ALTER TABLE public.tbl_periode OWNER TO postgres;

--
-- Name: tbl_periode_analisis_data; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_periode_analisis_data (
    id bigint NOT NULL,
    nama_periode_analisis_data character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.tbl_periode_analisis_data OWNER TO postgres;

--
-- Name: tbl_periode_analisis_data_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_periode_analisis_data_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_periode_analisis_data_id_seq OWNER TO postgres;

--
-- Name: tbl_periode_analisis_data_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_periode_analisis_data_id_seq OWNED BY public.tbl_periode_analisis_data.id;


--
-- Name: tbl_periode_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_periode_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_periode_id_seq OWNER TO postgres;

--
-- Name: tbl_periode_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_periode_id_seq OWNED BY public.tbl_periode.id;


--
-- Name: tbl_periode_pengumpulan_data; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_periode_pengumpulan_data (
    id bigint NOT NULL,
    nama_periode_pengumpulan_data character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.tbl_periode_pengumpulan_data OWNER TO postgres;

--
-- Name: tbl_periode_pengumpulan_data_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_periode_pengumpulan_data_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_periode_pengumpulan_data_id_seq OWNER TO postgres;

--
-- Name: tbl_periode_pengumpulan_data_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_periode_pengumpulan_data_id_seq OWNED BY public.tbl_periode_pengumpulan_data.id;


--
-- Name: tbl_periode_unit_deadline; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_periode_unit_deadline (
    id bigint NOT NULL,
    periode_id bigint NOT NULL,
    unit_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.tbl_periode_unit_deadline OWNER TO postgres;

--
-- Name: tbl_periode_unit_deadline_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_periode_unit_deadline_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_periode_unit_deadline_id_seq OWNER TO postgres;

--
-- Name: tbl_periode_unit_deadline_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_periode_unit_deadline_id_seq OWNED BY public.tbl_periode_unit_deadline.id;


--
-- Name: tbl_role; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_role (
    id bigint NOT NULL,
    nama_role character varying(255) NOT NULL,
    deskripsi_role character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.tbl_role OWNER TO postgres;

--
-- Name: tbl_role_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_role_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_role_id_seq OWNER TO postgres;

--
-- Name: tbl_role_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_role_id_seq OWNED BY public.tbl_role.id;


--
-- Name: tbl_unit; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_unit (
    id bigint NOT NULL,
    kode_unit character varying(255) NOT NULL,
    nama_unit character varying(255) NOT NULL,
    deskripsi_unit text,
    status_unit character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT tbl_unit_status_unit_check CHECK (((status_unit)::text = ANY (ARRAY[('aktif'::character varying)::text, ('non-aktif'::character varying)::text])))
);


ALTER TABLE public.tbl_unit OWNER TO postgres;

--
-- Name: tbl_unit_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_unit_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_unit_id_seq OWNER TO postgres;

--
-- Name: tbl_unit_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_unit_id_seq OWNED BY public.tbl_unit.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    nama_lengkap character varying(255) NOT NULL,
    nip character varying(255),
    username character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    role_id integer,
    unit_id integer,
    profesi character varying(255),
    atasan_langsung character varying(255),
    status_user character varying(255) DEFAULT 'pending'::character varying NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT users_profesi_check CHECK (((profesi)::text = ANY (ARRAY[('Medis'::character varying)::text, ('Non Medis'::character varying)::text]))),
    CONSTRAINT users_status_user_check CHECK (((status_user)::text = ANY (ARRAY[('pending'::character varying)::text, ('aktif'::character varying)::text, ('non-aktif'::character varying)::text])))
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
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: tbl_dimensi_mutu id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_dimensi_mutu ALTER COLUMN id SET DEFAULT nextval('public.tbl_dimensi_mutu_id_seq'::regclass);


--
-- Name: tbl_hak_akses id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_hak_akses ALTER COLUMN id SET DEFAULT nextval('public.tbl_hak_akses_id_seq'::regclass);


--
-- Name: tbl_hasil_analisa id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_hasil_analisa ALTER COLUMN id SET DEFAULT nextval('public.tbl_hasil_analisa_id_seq'::regclass);


--
-- Name: tbl_indikator id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_indikator ALTER COLUMN id SET DEFAULT nextval('public.tbl_indikator_id_seq'::regclass);


--
-- Name: tbl_indikator_periode id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_indikator_periode ALTER COLUMN id SET DEFAULT nextval('public.tbl_indikator_periode_id_seq'::regclass);


--
-- Name: tbl_jenis_indikator id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_jenis_indikator ALTER COLUMN id SET DEFAULT nextval('public.tbl_jenis_indikator_id_seq'::regclass);


--
-- Name: tbl_kamus_indikator id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_kamus_indikator ALTER COLUMN id SET DEFAULT nextval('public.tbl_kamus_indikator_id_seq'::regclass);


--
-- Name: tbl_kategori_imprs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_kategori_imprs ALTER COLUMN id SET DEFAULT nextval('public.tbl_kategori_imprs_id_seq'::regclass);


--
-- Name: tbl_laporan_dan_analis id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_laporan_dan_analis ALTER COLUMN id SET DEFAULT nextval('public.tbl_laporan_dan_analis_id_seq'::regclass);


--
-- Name: tbl_laporan_validator id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_laporan_validator ALTER COLUMN id SET DEFAULT nextval('public.tbl_laporan_validator_id_seq'::regclass);


--
-- Name: tbl_metode_pengumpulan_data id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_metode_pengumpulan_data ALTER COLUMN id SET DEFAULT nextval('public.tbl_metode_pengumpulan_data_id_seq'::regclass);


--
-- Name: tbl_pdsa id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_pdsa ALTER COLUMN id SET DEFAULT nextval('public.tbl_pdsa_id_seq'::regclass);


--
-- Name: tbl_pdsa_assignments id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_pdsa_assignments ALTER COLUMN id SET DEFAULT nextval('public.tbl_pdsa_assignments_id_seq'::regclass);


--
-- Name: tbl_penyajian_data id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_penyajian_data ALTER COLUMN id SET DEFAULT nextval('public.tbl_penyajian_data_id_seq'::regclass);


--
-- Name: tbl_periode id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_periode ALTER COLUMN id SET DEFAULT nextval('public.tbl_periode_id_seq'::regclass);


--
-- Name: tbl_periode_analisis_data id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_periode_analisis_data ALTER COLUMN id SET DEFAULT nextval('public.tbl_periode_analisis_data_id_seq'::regclass);


--
-- Name: tbl_periode_pengumpulan_data id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_periode_pengumpulan_data ALTER COLUMN id SET DEFAULT nextval('public.tbl_periode_pengumpulan_data_id_seq'::regclass);


--
-- Name: tbl_periode_unit_deadline id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_periode_unit_deadline ALTER COLUMN id SET DEFAULT nextval('public.tbl_periode_unit_deadline_id_seq'::regclass);


--
-- Name: tbl_role id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_role ALTER COLUMN id SET DEFAULT nextval('public.tbl_role_id_seq'::regclass);


--
-- Name: tbl_unit id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_unit ALTER COLUMN id SET DEFAULT nextval('public.tbl_unit_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache (key, value, expiration) FROM stdin;
laravel-cache-fbcba30cb5caf9ae8643f972cc16d4ee574727cb:timer	i:1776303580;	1776303580
laravel-cache-fbcba30cb5caf9ae8643f972cc16d4ee574727cb	i:1;	1776303580
laravel-cache-dashboard_total_pdsa_aktif_21	i:0;	1776309708
laravel-cache-dashboard_pdsa_list_21	TzoyOToiSWxsdW1pbmF0ZVxTdXBwb3J0XENvbGxlY3Rpb24iOjI6e3M6ODoiACoAaXRlbXMiO2E6MDp7fXM6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDt9	1776306708
laravel-cache-dashboard_total_pdsa_aktif_17	i:0;	1776319952
laravel-cache-dashboard_pdsa_list_17	TzoyOToiSWxsdW1pbmF0ZVxTdXBwb3J0XENvbGxlY3Rpb24iOjI6e3M6ODoiACoAaXRlbXMiO2E6MDp7fXM6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDt9	1776316952
laravel-cache-4183b9d3e8aadc6d97b2e42b28a93f0eae49680c:timer	i:1776311318;	1776311318
laravel-cache-4183b9d3e8aadc6d97b2e42b28a93f0eae49680c	i:1;	1776311318
laravel-cache-dashboard_total_pdsa_aktif_39	i:0;	1776314858
laravel-cache-dashboard_total_pdsa_aktif_22	i:0;	1776310304
laravel-cache-dashboard_pdsa_list_39	TzoyOToiSWxsdW1pbmF0ZVxTdXBwb3J0XENvbGxlY3Rpb24iOjI6e3M6ODoiACoAaXRlbXMiO2E6MDp7fXM6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDt9	1776311858
laravel-cache-3aa787eb858b905ac66a3edd8f9a4641b57f5553:timer	i:1776316785;	1776316785
laravel-cache-3aa787eb858b905ac66a3edd8f9a4641b57f5553	i:1;	1776316785
laravel-cache-ff9d852f0df78e67507e7264922285d4d172ffd4:timer	i:1776307951;	1776307951
laravel-cache-ff9d852f0df78e67507e7264922285d4d172ffd4	i:1;	1776307951
laravel-cache-dashboard_total_pdsa_aktif_23	i:0;	1776315356
laravel-cache-dashboard_pdsa_list_23	TzoyOToiSWxsdW1pbmF0ZVxTdXBwb3J0XENvbGxlY3Rpb24iOjI6e3M6ODoiACoAaXRlbXMiO2E6MDp7fXM6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDt9	1776312356
laravel-cache-dashboard_total_pdsa_all	i:0;	1776323254
laravel-cache-dashboard_pdsa_list_all	TzoyOToiSWxsdW1pbmF0ZVxTdXBwb3J0XENvbGxlY3Rpb24iOjI6e3M6ODoiACoAaXRlbXMiO2E6MDp7fXM6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDt9	1776320254
laravel-cache-091e21aba811cbbc2effcc937e179c17e74817ff:timer	i:1776312404;	1776312404
laravel-cache-39937a36e6d72ce469b2083cde3d4c8184632641:timer	i:1776312895;	1776312895
laravel-cache-periode_aktif	O:8:"stdClass":10:{s:2:"id";i:1;s:12:"nama_periode";s:17:"Periode Mutu 2026";s:5:"tahun";i:2026;s:13:"tanggal_mulai";s:10:"2026-01-01";s:15:"tanggal_selesai";s:10:"2026-12-31";s:8:"deadline";i:5;s:15:"status_deadline";b:0;s:6:"status";s:5:"aktif";s:10:"created_at";s:19:"2026-04-15 08:29:31";s:10:"updated_at";s:19:"2026-04-15 08:29:31";}	1776320040
laravel-cache-dashboard_total_pdsa_aktif_2	i:0;	1776306861
laravel-cache-dashboard_pdsa_list_2	TzoyOToiSWxsdW1pbmF0ZVxTdXBwb3J0XENvbGxlY3Rpb24iOjI6e3M6ODoiACoAaXRlbXMiO2E6MDp7fXM6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDt9	1776303861
laravel-cache-091e21aba811cbbc2effcc937e179c17e74817ff	i:1;	1776312404
laravel-cache-dashboard_pdsa_list_22	TzoyOToiSWxsdW1pbmF0ZVxTdXBwb3J0XENvbGxlY3Rpb24iOjI6e3M6ODoiACoAaXRlbXMiO2E6MDp7fXM6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDt9	1776309888
laravel-cache-ba11f75a08adc39d40c0659e610230844b3a685c:timer	i:1776309566;	1776309566
laravel-cache-ba11f75a08adc39d40c0659e610230844b3a685c	i:1;	1776309566
laravel-cache-39937a36e6d72ce469b2083cde3d4c8184632641	i:1;	1776312895
laravel-cache-dashboard_total_pdsa_aktif_45	i:0;	1776316435
laravel-cache-dashboard_pdsa_list_45	TzoyOToiSWxsdW1pbmF0ZVxTdXBwb3J0XENvbGxlY3Rpb24iOjI6e3M6ODoiACoAaXRlbXMiO2E6MDp7fXM6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDt9	1776313435
laravel-cache-9c4fc8f1aa5787fa8a6cafd17e58296a2c9b8c73:timer	i:1776313298;	1776313298
laravel-cache-9c4fc8f1aa5787fa8a6cafd17e58296a2c9b8c73	i:1;	1776313298
laravel-cache-dashboard_total_pdsa_aktif_5	i:0;	1776316839
laravel-cache-dashboard_pdsa_list_5	TzoyOToiSWxsdW1pbmF0ZVxTdXBwb3J0XENvbGxlY3Rpb24iOjI6e3M6ODoiACoAaXRlbXMiO2E6MDp7fXM6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDt9	1776313839
laravel-cache-dashboard_total_pdsa_aktif_47	i:0;	1776317048
laravel-cache-dashboard_pdsa_list_47	TzoyOToiSWxsdW1pbmF0ZVxTdXBwb3J0XENvbGxlY3Rpb24iOjI6e3M6ODoiACoAaXRlbXMiO2E6MDp7fXM6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDt9	1776314048
laravel-cache-dashboard_total_pdsa_aktif_6	i:0;	1776318119
laravel-cache-dashboard_pdsa_list_6	TzoyOToiSWxsdW1pbmF0ZVxTdXBwb3J0XENvbGxlY3Rpb24iOjI6e3M6ODoiACoAaXRlbXMiO2E6MDp7fXM6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDt9	1776315119
\.


--
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.


--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_01_000000_create_users_table	1
2	0001_01_01_000001_create_cache_table	1
3	0001_01_01_000002_create_jobs_table	1
4	2025_11_28_011825_create_tbl_indikator_units_table	1
5	2025_11_28_011840_create_tbl_kamus_indikator_mutu_units_table	1
6	2025_11_28_011858_create_tbl_laporan_dan_analis_table	1
7	2025_11_28_011905_create_tbl_units_table	1
8	2025_11_28_011945_create_tbl_periode_analisis_datas_table	1
9	2025_11_28_012020_create_tbl_penyajian_datas_table	1
10	2025_11_28_012032_create_tbl_roles_table	1
11	2025_11_28_012054_create_tbl_metode_pengumpulan_datas_table	1
12	2025_11_28_012105_create_tbl_periode_pengumpulan_datas_table	1
13	2025_11_28_012112_create_tbl_dimensi_mutus_table	1
14	2025_12_04_014729_create_tbl_pdsas_table	1
15	2025_12_04_063842_create_tbl_hak_akses_table	1
16	2025_12_31_044229_create_tbl_kategori_imprs_table	1
17	2026_01_21_022117_create_tbl_pdsa_assignments_table	1
18	2026_01_26_020928_create_tbl_periodes_table	1
19	2026_02_03_072637_create_tbl_jenis_indikators_table	1
20	2026_02_05_034741_create_tbl_indikator_periodes_table	1
21	2026_02_13_021836_create_tbl_laporan_validators_table	1
22	2026_02_18_014517_create_tbl_hasil_analisas_table	1
23	2026_03_04_033255_create_tbl_periode_unit_deadlines_table	1
24	2026_03_10_000000_add_indexes_to_tbl_laporan_dan_analis	1
\.


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
GoaPMhSnmYH3hK5dC1EKnIQupsz9MYJ2gParedki	30	192.168.0.40	Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0	YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTzNDN0x4cDA5N2xhR2Y2RGVhM3lyaVk3b1R6bEl1aWExcm80Y2xkaCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTIyOiJodHRwOi8vMTkyLjE2OC4wLjIzMzo4MDg3L2xhcG9yYW4tYW5hbGlzP2J1bGFuPTEmaW5kaWthdG9yX2lkPTQ3JmthdGVnb3JpX2luZGlrYXRvcj1wcmlvcml0YXMlMjB1bml0JnRhaHVuPTIwMjYmdW5pdF9pZD0xNyI7czo1OiJyb3V0ZSI7czoyMDoibGFwb3Jhbi1hbmFsaXMuaW5kZXgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozMDt9	1776316682
J7l1999KOZqriO5yfprodGZqZu03cIoYHiafPpvu	1	192.168.0.241	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36	YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVTZyS1FkVnliTjhENE1IM1g3ZlVCU2N0dkFLanFzblVOdU05VEd0QSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Nzg6Imh0dHA6Ly8xOTIuMTY4LjAuMjMzOjgwODcvZGFzaGJvYXJkL2NoYXJ0LWRhdGE/dGFodW49MjAyNiZ0eXBlPXVuaXQmdW5pdF9pZD00NyI7czo1OiJyb3V0ZSI7czoyMDoiZGFzaGJvYXJkLmNoYXJ0LWRhdGEiO31zOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjI1OiJodHRwOi8vMTkyLjE2OC4wLjIzMzo4MDg3Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9	1776319670
PvViRNReAg0D0r1ne9iDcFynbFp69qDz1hksAgnT	219	192.168.0.90	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0	YTo1OntzOjY6Il90b2tlbiI7czo0MDoibDFqZ0hncEJFUVZ0U3NQUTZGMG9hUDdhamJEVUo3QlBwQVBKbHRSZCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNToiaHR0cDovLzE5Mi4xNjguMC4yMzM6ODA4NyI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjY2OiJodHRwOi8vMTkyLjE2OC4wLjIzMzo4MDg3L2Rhc2hib2FyZC9jaGFydC1kYXRhP3RhaHVuPTIwMjYmdHlwZT1pbW4iO3M6NToicm91dGUiO3M6MjA6ImRhc2hib2FyZC5jaGFydC1kYXRhIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjE5O30=	1776312888
ZNO7LY948cD4EsZ3S2lmika6xNZ3azzFmKAIWLLq	21	192.168.0.28	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36	YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWGpxSjJieFdKM3dvZXNOb2loVmN1bXE0dzFjZVJWQUJNRnBMcjNTSSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNToiaHR0cDovLzE5Mi4xNjguMC4yMzM6ODA4NyI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQwOiJodHRwOi8vMTkyLjE2OC4wLjIzMzo4MDg3L2xhcG9yYW4tYW5hbGlzIjtzOjU6InJvdXRlIjtzOjIwOiJsYXBvcmFuLWFuYWxpcy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjIxO30=	1776313299
uhsd8N9QwvGTrgpaSZ6jwxCKmN7IQ4qIYLiq8YMy	1	192.168.0.173	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0	YTo0OntzOjY6Il90b2tlbiI7czo0MDoiU2Q2UmU1MmNNMG1UOHFkS3pLbUd0SlBSVDFSVDBSV2xRbldqYW9FdCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xOTIuMTY4LjAuMjMzOjgwODcvbWFzdGVyLWluZGlrYXRvciI7czo1OiJyb3V0ZSI7czoyMjoibWFzdGVyLWluZGlrYXRvci5pbmRleCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==	1776313557
MlM2Uujbkys88e4LA9A6gYoHBSjyEXrDeHxrNAvR	249	192.168.0.131	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36	YTo1OntzOjY6Il90b2tlbiI7czo0MDoiT1JLSHRLRlpIZzRMaGNPdlIwdVY5YXpvUkxEY1VsaGVudWFiZmlCYyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MDoiaHR0cDovLzE5Mi4xNjguMC4yMzM6ODA4Ny9sYXBvcmFuLWFuYWxpcyI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjUwOiJodHRwOi8vMTkyLjE2OC4wLjIzMzo4MDg3L2thbXVzLWluZGlrYXRvci8xMDAvZWRpdCI7czo1OiJyb3V0ZSI7czoyMDoia2FtdXMtaW5kaWthdG9yLmVkaXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyNDk7fQ==	1776320055
tA8R7R4vUhOiVbijYODW3CVqiBo7kcV6rirrOOnj	30	192.168.0.131	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36	YTo1OntzOjY6Il90b2tlbiI7czo0MDoidzNEaGI4QTE5bFBMYnhMQjRKR25wUzlHNUgybFYzWmJpVWp3ek5BeSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNToiaHR0cDovLzE5Mi4xNjguMC4yMzM6ODA4NyI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjk1OiJodHRwOi8vMTkyLjE2OC4wLjIzMzo4MDg3L2xhcG9yYW4tYW5hbGlzP2J1bGFuPTIma2F0ZWdvcmlfaW5kaWthdG9yPXByaW9yaXRhcyUyMHVuaXQmdGFodW49MjAyNiI7czo1OiJyb3V0ZSI7czoyMDoibGFwb3Jhbi1hbmFsaXMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozMDt9	1776318536
XZNgOAwdbmTTozdniowLPxdUBxd7rhjd7qGvC78q	27	192.168.0.131	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36	YTo1OntzOjY6Il90b2tlbiI7czo0MDoiRzlscElES29hTXl2YkJBSENTbDRwSERTa0hvOTVkamw0RkQyYld6SiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNToiaHR0cDovLzE5Mi4xNjguMC4yMzM6ODA4NyI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQzOiJodHRwOi8vMTkyLjE2OC4wLjIzMzo4MDg3L2xhcG9yYW4tdmFsaWRhdG9yIjtzOjU6InJvdXRlIjtzOjIzOiJsYXBvcmFuLXZhbGlkYXRvci5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI3O30=	1776314678
\.


--
-- Data for Name: tbl_dimensi_mutu; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_dimensi_mutu (id, nama_dimensi_mutu, created_at, updated_at) FROM stdin;
1	Keselamatan	\N	\N
2	Efektivitas	\N	\N
3	Berfokus pada Pasien	\N	\N
4	Ketepatan Waktu	\N	\N
5	Efisiensi	\N	\N
6	Keadilan / Kesetaraan	\N	\N
7	Kesinambungan / Integrasi Pelayanan	\N	\N
\.


--
-- Data for Name: tbl_hak_akses; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_hak_akses (id, role_id, menu_key, created_at, updated_at) FROM stdin;
1	2	dashboard	2026-04-16 01:16:58	2026-04-16 01:16:58
2	2	master_indikator	2026-04-16 01:16:58	2026-04-16 01:16:58
3	2	kamus_indikator	2026-04-16 01:16:58	2026-04-16 01:16:58
4	2	laporan_analis	2026-04-16 01:16:58	2026-04-16 01:16:58
5	2	laporan_validator	2026-04-16 01:16:58	2026-04-16 01:16:58
6	2	analisa_data	2026-04-16 01:16:58	2026-04-16 01:16:58
7	2	pdsa	2026-04-16 01:16:58	2026-04-16 01:16:58
8	2	periode_mutu	2026-04-16 01:16:58	2026-04-16 01:16:58
9	3	dashboard	2026-04-16 01:17:09	2026-04-16 01:17:09
10	3	master_indikator	2026-04-16 01:17:09	2026-04-16 01:17:09
11	3	kamus_indikator	2026-04-16 01:17:09	2026-04-16 01:17:09
12	3	laporan_analis	2026-04-16 01:17:09	2026-04-16 01:17:09
13	3	laporan_validator	2026-04-16 01:17:09	2026-04-16 01:17:09
14	3	analisa_data	2026-04-16 01:17:09	2026-04-16 01:17:09
15	3	pdsa	2026-04-16 01:17:09	2026-04-16 01:17:09
16	4	dashboard	2026-04-16 01:17:18	2026-04-16 01:17:18
17	4	master_indikator	2026-04-16 01:17:18	2026-04-16 01:17:18
18	4	kamus_indikator	2026-04-16 01:17:18	2026-04-16 01:17:18
19	4	laporan_analis	2026-04-16 01:17:18	2026-04-16 01:17:18
20	4	analisa_data	2026-04-16 01:17:18	2026-04-16 01:17:18
21	4	pdsa	2026-04-16 01:17:18	2026-04-16 01:17:18
22	5	dashboard	2026-04-16 01:17:29	2026-04-16 01:17:29
23	5	master_indikator	2026-04-16 01:17:29	2026-04-16 01:17:29
24	5	kamus_indikator	2026-04-16 01:17:29	2026-04-16 01:17:29
25	5	laporan_analis	2026-04-16 01:17:29	2026-04-16 01:17:29
26	5	laporan_validator	2026-04-16 01:17:29	2026-04-16 01:17:29
27	5	analisa_data	2026-04-16 01:17:29	2026-04-16 01:17:29
28	5	pdsa	2026-04-16 01:17:29	2026-04-16 01:17:29
29	6	dashboard	2026-04-16 01:17:37	2026-04-16 01:17:37
30	6	master_indikator	2026-04-16 01:17:37	2026-04-16 01:17:37
31	6	kamus_indikator	2026-04-16 01:17:37	2026-04-16 01:17:37
32	6	laporan_analis	2026-04-16 01:17:37	2026-04-16 01:17:37
33	6	laporan_validator	2026-04-16 01:17:37	2026-04-16 01:17:37
34	6	analisa_data	2026-04-16 01:17:37	2026-04-16 01:17:37
35	6	pdsa	2026-04-16 01:17:37	2026-04-16 01:17:37
36	7	dashboard	2026-04-16 01:17:46	2026-04-16 01:17:46
37	7	master_indikator	2026-04-16 01:17:46	2026-04-16 01:17:46
38	7	kamus_indikator	2026-04-16 01:17:46	2026-04-16 01:17:46
39	7	laporan_analis	2026-04-16 01:17:46	2026-04-16 01:17:46
40	7	laporan_validator	2026-04-16 01:17:46	2026-04-16 01:17:46
41	7	analisa_data	2026-04-16 01:17:46	2026-04-16 01:17:46
42	7	pdsa	2026-04-16 01:17:46	2026-04-16 01:17:46
43	8	dashboard	2026-04-16 01:17:55	2026-04-16 01:17:55
44	8	master_indikator	2026-04-16 01:17:55	2026-04-16 01:17:55
45	8	kamus_indikator	2026-04-16 01:17:55	2026-04-16 01:17:55
46	8	laporan_analis	2026-04-16 01:17:55	2026-04-16 01:17:55
47	8	laporan_validator	2026-04-16 01:17:55	2026-04-16 01:17:55
48	8	analisa_data	2026-04-16 01:17:55	2026-04-16 01:17:55
49	8	pdsa	2026-04-16 01:17:55	2026-04-16 01:17:55
50	9	dashboard	2026-04-16 01:18:04	2026-04-16 01:18:04
51	9	master_indikator	2026-04-16 01:18:04	2026-04-16 01:18:04
52	9	kamus_indikator	2026-04-16 01:18:04	2026-04-16 01:18:04
53	9	laporan_analis	2026-04-16 01:18:04	2026-04-16 01:18:04
54	9	laporan_validator	2026-04-16 01:18:04	2026-04-16 01:18:04
55	9	analisa_data	2026-04-16 01:18:04	2026-04-16 01:18:04
56	9	pdsa	2026-04-16 01:18:04	2026-04-16 01:18:04
57	10	dashboard	2026-04-16 01:18:12	2026-04-16 01:18:12
58	10	master_indikator	2026-04-16 01:18:12	2026-04-16 01:18:12
59	10	kamus_indikator	2026-04-16 01:18:12	2026-04-16 01:18:12
60	10	laporan_analis	2026-04-16 01:18:12	2026-04-16 01:18:12
61	10	laporan_validator	2026-04-16 01:18:12	2026-04-16 01:18:12
62	10	analisa_data	2026-04-16 01:18:12	2026-04-16 01:18:12
63	10	pdsa	2026-04-16 01:18:12	2026-04-16 01:18:12
\.


--
-- Data for Name: tbl_hasil_analisa; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_hasil_analisa (id, indikator_id, tanggal_analisa, analisa, tindak_lanjut, unit_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: tbl_indikator; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_indikator (id, nama_indikator, target_indikator, target_min, target_max, arah_target, status_indikator, unit_id, kamus_indikator_id, keterangan, created_at, updated_at) FROM stdin;
5	Waktu Tunggu Rawat Jalan	80.00	\N	\N	lebih_besar	aktif	7	5	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
6	Penundaan Operasi Elektif	5.00	\N	\N	lebih_kecil	aktif	27	6	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
7	Kepatuhan Waktu Visite Dokter	80.00	\N	\N	lebih_besar	aktif	45	7	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
15	Tidak ada kesalahan Pemberian Obat di Rawat Inap	100.00	\N	\N	lebih_besar	aktif	45	15	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
16	Tidak ada kesalahan memasukan obat ke plastik etiket pasien lain di Farmasi	100.00	\N	\N	lebih_besar	aktif	21	16	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
17	Tidak ada kesalahan input hasil expertise Radiologi oleh Radiografer ke E-MR	100.00	\N	\N	lebih_besar	aktif	34	17	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
18	Tidak ada kesalahan pemberian obat pulang pasien rawat inap	100.00	\N	\N	lebih_besar	aktif	45	18	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
19	Kepatuhan Verifikasi SBAR instruksi via telepon di Rawat Inap	100.00	\N	\N	lebih_besar	aktif	45	19	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
23	Tidak ada kejadian Pasien Jatuh di Area Layanan	100.00	\N	\N	lebih_besar	aktif	50	23	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
26	kesesuaian waktu tunggu pemulangan pasien rawat inap < 2 jam	80.00	\N	\N	lebih_besar	aktif	45	26	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
27	Maternity : Ketepatan Waktu Operasi SC Elektif < 45 menit sesuai jadwal	80.00	\N	\N	lebih_besar	aktif	27	27	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
30	Waktu tunggu hasil expertise Radiologi (Foto Thorax < 3 jam, USG < 60 Menit, CT Scan < 6 Jam	80.00	\N	\N	lebih_besar	aktif	34	30	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
31	Respon Time Menjawab Permintaan Rujukan Melalui Sistem Rujukan	80.00	\N	\N	lebih_besar	aktif	18	31	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
33	Kepatuhan Perawat Melakukan TTV dan Penginputan di ERM	95.00	\N	\N	lebih_besar	aktif	7	33	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
34	Angka Kepatuhan Jam Praktek Dokter Spesialis Sesuai Jadwal	90.00	\N	\N	lebih_besar	aktif	7	34	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
37	Tidak Ada Kesalahan Pemberian Alergen pada Pasien Alergi di Rawat Inap	100.00	\N	\N	lebih_besar	aktif	45	37	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
39	Kepatuhan Pengisian Partograf pada Persalinan Kala I Fase Aktif	100.00	\N	\N	lebih_besar	aktif	44	39	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
40	Tidak Ada Kesalahan Penempelan Stiker Pasien KKebidanan di VK	100.00	\N	\N	lebih_besar	aktif	44	40	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
41	Readmission Rate ≤ 30 Hari	5.00	\N	\N	lebih_kecil	aktif	26	41	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
42	Kepatuhan Klaim INA-CBGs	95.00	\N	\N	lebih_besar	aktif	26	42	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
43	Case Mix Index (CMI)	1.20	\N	\N	lebih_kecil	aktif	26	43	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
51	Keterlambatan Waktu Mulai Operasi >30 Menit	2.00	\N	\N	lebih_kecil	aktif	27	51	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
52	Tidak Ada Kesalahan Penjadwalan Tindakan Operasi	100.00	\N	\N	lebih_besar	aktif	27	52	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
54	Tidak adanya Kesalahan dalam proses packing dan labeling	100.00	\N	\N	lebih_besar	aktif	27	54	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
55	Tidak adanya kerusakan kemasan setelah post sterilisasi	100.00	\N	\N	lebih_besar	aktif	27	55	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
56	Kepatuhan pengisian formulir permintaan sterilisasi	100.00	\N	\N	lebih_besar	aktif	27	56	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
57	Ketepatan kemasan alat medis dan linen steril sesuai perubahan warna indicator post sterilisasi	100.00	\N	\N	lebih_besar	aktif	27	57	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
59	Pemenuhan Waktu Tunggu Rontgen Thorax <= 3 Jam	100.00	\N	\N	lebih_besar	aktif	34	59	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
60	Tidak Ada Kesalahan Pemberian Hasil Laboratorium Pasien Lain	100.00	\N	\N	lebih_besar	aktif	8	60	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
45	Prosentase Klaim Tidak Layak	1.00	\N	\N	lebih_kecil	aktif	26	45	\N	2026-01-01 00:00:00	2026-04-15 08:43:08
38	Kejadian Pasien jatuh pada anak diruang rawat Inap	0.00	\N	\N	lebih_kecil	aktif	45	38	\N	2026-01-01 00:00:00	2026-04-15 08:45:11
49	Kejadian medication error oleh perawat dan bidan di Rumah Sakit Azra	1.00	\N	\N	lebih_kecil	aktif	50	49	\N	2026-01-01 00:00:00	2026-04-15 08:46:47
14	Tidak ada kesalahan input jumlah obat dalam E-Resep oleh dokter spesialis di Poliklinik	100.00	\N	\N	lebih_besar	aktif	7	14	\N	2026-01-01 00:00:00	2026-04-15 08:47:33
35	Angka Kejadian Mesin Hemodialisa Rusak Saat Digunakan	0.00	\N	\N	lebih_kecil	aktif	7	35	\N	2026-01-01 00:00:00	2026-04-15 08:47:59
36	Angka Kejadian Hipotensi Intradialisis	20.00	\N	\N	lebih_kecil	aktif	7	36	\N	2026-01-01 00:00:00	2026-04-15 08:48:10
28	Waktu tunggu Obat di Farmasi (Obat Jadi < 25 menit, Obat Racikan < 55 menit)	100.00	\N	\N	lebih_besar	aktif	21	28	\N	2026-01-01 00:00:00	2026-04-16 03:59:19
46	Kepatuhan Assesmen Akhir Kehidupan pada Pasien Terminal	85.00	\N	\N	lebih_besar	aktif	17	46	\N	2026-01-01 00:00:00	2026-04-16 03:22:22
47	Angka Ventilator Associated Pnemonia (VAP) di ruang Intensif	0.00	\N	\N	lebih_kecil	aktif	17	47	\N	2026-01-01 00:00:00	2026-04-16 03:22:39
61	Kesesuaian  Pemeriksaan  Laboratorium  sesuai dengan Perjanjian	100.00	\N	\N	lebih_besar	aktif	8	61	\N	2026-01-01 00:00:00	2026-04-15 08:54:05
13	Kepuasan Pasien	76.61	\N	\N	lebih_besar	aktif	53	13	\N	2026-01-01 00:00:00	2026-04-16 03:39:48
29	Kelengkapan berkas Discharge Planning H-1	80.00	\N	\N	lebih_besar	aktif	45	29	\N	2026-01-01 00:00:00	2026-04-16 03:49:44
3	Kepatuhan Identifikasi Pasien	100.00	\N	\N	lebih_besar	aktif	50	3	\N	2026-01-01 00:00:00	2026-04-16 03:35:58
25	Kepatuhan Tatalaksanan Clinical Pathway DHF Anak	100.00	\N	\N	lebih_besar	aktif	45	25	\N	2026-01-01 00:00:00	2026-04-16 03:01:34
24	Kepatuhan Tatalaksana Clinical Pathway Pneumonia / BP Anak	100.00	\N	\N	lebih_besar	aktif	45	24	\N	2026-01-01 00:00:00	2026-04-16 03:03:03
12	Kecepatan Waktu Tanggap Komplain	80.00	\N	\N	lebih_besar	aktif	53	12	\N	2026-01-01 00:00:00	2026-04-16 03:35:40
2	Kepatuhan Penggunaan Alat Pelindung Diri (APD)	100.00	\N	\N	lebih_besar	aktif	35	2	\N	2026-01-01 00:00:00	2026-04-16 03:36:23
9	Kepatuhan Penggunaan Formularium Nasional	80.00	\N	\N	lebih_besar	aktif	21	9	\N	2026-01-01 00:00:00	2026-04-16 03:36:55
10	Kepatuhan Terhadap Clinical Pathway	80.00	\N	\N	lebih_besar	aktif	45	10	\N	2026-01-01 00:00:00	2026-04-16 03:37:37
8	Pelaporan Hasil Kritis Laboratorium	80.00	\N	\N	lebih_besar	aktif	8	8	\N	2026-01-01 00:00:00	2026-04-16 03:40:15
4	Waktu Tanggap Operasi Seksio Sesarea Emergensi < 30 menit	80.00	\N	\N	lebih_besar	aktif	44	4	\N	2026-01-01 00:00:00	2026-04-16 03:41:04
32	Waktu Tunggu Pasien di Instalasi Gawat Darurat	80.00	\N	\N	lebih_besar	aktif	18	32	\N	2026-01-01 00:00:00	2026-04-16 03:50:04
22	Kepatuhan Cuci Tangan 6 langkah	100.00	\N	\N	lebih_besar	aktif	35	22	\N	2026-01-01 00:00:00	2026-04-16 03:51:22
48	Kejadian Iritasi pada Bayi yang dilakukan Fototerapi	0.00	\N	\N	lebih_kecil	aktif	55	118	\N	2026-01-01 00:00:00	2026-04-16 04:31:20
62	Kepatuhan Pelaporan Hasil Laboratorium Nilai Kritis	90.00	\N	\N	lebih_besar	aktif	8	62	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
64	Ketepatan Waktu Menyediakan Makanan Katering	100.00	\N	\N	lebih_besar	aktif	3	64	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
65	Tidak Ada Kesalahan Penempelan Etiket Obat di Farmasi Rawat Jalan	100.00	\N	\N	lebih_besar	aktif	21	65	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
66	Tidak Ada Kesalahan Penulisan Dosis pada Etiket Obat di Farmasi	100.00	\N	\N	lebih_besar	aktif	21	66	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
68	Kelengkapan Laporan Operasi	100.00	\N	\N	lebih_besar	aktif	41	68	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
71	Kejadian Luka Bakar Akibat Tindakan Elektroterapi	0.00	\N	\N	lebih_kecil	aktif	29	71	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
72	Persentase Kepatuhan Kedatangan Pasien Kontrol ke Dokter Spesialis Pasca Reminder	80.00	\N	\N	lebih_besar	aktif	37	72	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
73	Persentase Kesalahan Input Data Identitas Pasien di Bagian Pendaftaran.	0.00	\N	\N	lebih_kecil	aktif	37	73	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
74	Persentase Kesesuaian Booking Online dengan Kehadiran Pasien Rawat Jalan	80.00	\N	\N	lebih_besar	aktif	37	74	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
75	Persentase Akurasi Penentuan Payor Asuransi di Pendaftaran Rawat Jalan	100.00	\N	\N	lebih_besar	aktif	37	75	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
82	Respon Time Menanggapi Kerusakan Alat	90.00	\N	\N	lebih_besar	aktif	6	82	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
83	Ketepatan Waktu Pemeliharaan Utilitas	100.00	\N	\N	lebih_besar	aktif	6	83	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
84	Angka Keluhan yang Ditindaklanjuti  dari Data Angket Keluhan Terkait Fasilitas	90.00	\N	\N	lebih_besar	aktif	6	84	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
85	Laporan Harian Internal Terkait Fasillitas	90.00	\N	\N	lebih_besar	aktif	6	85	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
93	Kepatuhan Ceklis Harian Kendaraan	100.00	\N	\N	lebih_besar	aktif	5	93	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
98	Persentase Proses Rekrutmen Level Staf yang Diselesaikan Tepat Waktu	85.00	\N	\N	lebih_besar	aktif	36	98	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
99	Ketepatan Waktu Penyusunan dan Review Perjanjian Manajerial (Contract)	80.00	\N	\N	lebih_besar	aktif	47	99	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
100	Waktu Respon Terhadap Permintaan Revisi Dokumen Hukum RS / Perjanjian (Contract) < 72 Jam	100.00	\N	\N	lebih_besar	aktif	47	100	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
101	Kecepatan Waktu Tunggu Perhitungan Pasien RI < 2 Jam	100.00	\N	\N	lebih_besar	aktif	30	101	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
102	Penagihan Klaim Asuransi	5.00	\N	\N	lebih_kecil	aktif	52	102	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
103	Pemantauan Aging Piutang Asuransi	10.00	\N	\N	lebih_kecil	aktif	52	103	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
104	Ketepatan penyajian nilai pendapatan BPJS dalam laporan keuangan	30.00	\N	\N	lebih_kecil	aktif	40	104	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
105	Ketepatan Waktu dalam Penyusunan, Pembayaran dan Pelaporan Pajak	100.00	\N	\N	lebih_besar	aktif	40	105	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
106	Rasio Arus Kas terhadap Pendapatan	80.00	\N	\N	lebih_besar	aktif	40	106	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
107	Ketepatan dalam Pengadaan Logistik Umum	100.00	\N	\N	lebih_besar	aktif	28	107	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
109	Tidak adanya Sterirecord Expired di unit Pelayanan	100.00	\N	\N	lebih_besar	aktif	35	109	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
110	Angka Insiden Petugas Tertusuk Benda Tajam dan Jarum	0.00	\N	\N	lebih_kecil	aktif	35	110	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
21	Tidak ada kesalahan penulisan lokasi operasi di Formulir Serah Terima Perawat di Kamar Operasi	100.00	\N	\N	lebih_besar	aktif	27	21	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
53	Ketersedian alat medis steril untuk tindak pelayanan pasien (Kamar Operasi dan IGD)	100.00	\N	\N	lebih_besar	aktif	27	53	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
58	Pemenuhan Waktu Tunggu Rontgen Thorax Cito < 30 Menit	100.00	\N	\N	lebih_besar	aktif	34	58	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
63	Pemenuhan Waktu Menyiapkan dan Menyajikan Menu < 45 menit	100.00	\N	\N	lebih_besar	aktif	3	63	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
79	Pengisian Angket Kepuasan Pasien Rawat Inap	30.00	\N	\N	lebih_besar	aktif	53	79	\N	2026-01-01 00:00:00	2026-04-15 08:39:38
80	Peningkatan Rujukan Pasien Luar	20.00	\N	\N	lebih_besar	aktif	54	80	\N	2026-01-01 00:00:00	2026-04-15 08:40:54
81	Peningkatan Jumlah Pengikut Baru dan Jumlah Interaksi pada Konten yang diposting	40.00	\N	\N	lebih_besar	aktif	54	81	\N	2026-01-01 00:00:00	2026-04-15 08:41:06
69	Kejadian Drop Out Pasien Terhadap Pelayanan Rehabilitasi Medik dan KTKA	0.00	\N	\N	lebih_kecil	aktif	29	69	\N	2026-01-01 00:00:00	2026-04-15 08:56:36
70	Kesalahan Tindakan Terapi Rehabilitasi Medik dan KTKA yang direncanakan	0.00	\N	\N	lebih_kecil	aktif	29	70	\N	2026-01-01 00:00:00	2026-04-15 08:56:46
97	Persentase Karyawan dengan Jam Pelatihan >20 Jam	85.00	\N	\N	lebih_besar	aktif	36	97	\N	2026-01-01 00:00:00	2026-04-15 08:59:01
86	Ketepatan Waktu Preventive Alkes	100.00	\N	\N	lebih_besar	aktif	6	86	\N	2026-01-01 00:00:00	2026-04-15 09:00:13
87	Respon Time Menanggapi Kerusakan Alkes	90.00	\N	\N	lebih_besar	aktif	6	87	\N	2026-01-01 00:00:00	2026-04-15 09:00:23
88	Angka komplain/ keluhan dari pasien (RI/ RJ) terhadap kebersihan kamar rawat inap, publik area, toilet umum, dan lingkungan rumah sakit (maksimal 15 komplain setiap bulan)	0.00	\N	\N	lebih_kecil	aktif	4	88	\N	2026-01-01 00:00:00	2026-04-15 09:02:51
89	Ketersediaan Linen Untuk Pasien Sesuai dengan Parstock Untuk Jumlah Bed yang Tersedia Dalam Waktu 1 x 24 jam	90.00	\N	\N	lebih_besar	aktif	4	89	\N	2026-01-01 00:00:00	2026-04-15 09:03:01
90	Angka Penyelesaian Laporan kasus yang ditangani Security maksimal 3x24 jam sejak penerimaan laporan	100.00	\N	\N	lebih_besar	aktif	4	90	\N	2026-01-01 00:00:00	2026-04-15 09:03:12
91	Tidak ada kejadian kehilangan aksesoris kendaraan yang terparkir di RS Azra	20.00	\N	\N	lebih_besar	aktif	4	91	\N	2026-01-01 00:00:00	2026-04-15 09:03:29
92	Ketepatan Jadwal Pengangkutan Limbah B3 Medis di TPS LB3	100.00	\N	\N	lebih_besar	aktif	4	92	\N	2026-01-01 00:00:00	2026-04-15 09:03:40
95	Response Time Sopir dalam On Call	100.00	\N	\N	lebih_besar	aktif	5	95	\N	2026-01-01 00:00:00	2026-04-15 09:05:59
94	Kepatuhan Security Melaksanakan Patroli	100.00	\N	\N	lebih_besar	aktif	5	94	\N	2026-01-01 00:00:00	2026-04-15 09:06:09
108	Ketepatan dalam Pengadaan Sediaan Farmasi	100.00	\N	\N	lebih_besar	aktif	28	108	\N	2026-01-01 00:00:00	2026-04-16 03:19:03
78	Penanganan Langsung Handling Komplain Pasien oleh Masing Masing Unit	80.00	\N	\N	lebih_besar	aktif	53	78	\N	2026-01-01 00:00:00	2026-04-16 03:22:43
96	Penyelesaian terhadap permintaan perbaikan fasilitas SIMRS < 10 menit	90.00	\N	\N	lebih_besar	aktif	23	96	\N	2026-01-01 00:00:00	2026-04-16 03:28:44
1	Kepatuhan Kebersihan Tangan	85.00	\N	\N	lebih_besar	aktif	35	1	\N	2026-01-01 00:00:00	2026-04-16 03:36:15
11	Kepatuhan Upaya Pencegahan Risiko Pasien Jatuh	80.00	\N	\N	lebih_besar	aktif	45	11	\N	2026-01-01 00:00:00	2026-04-16 03:38:16
77	Persentase Pemanggilan Kembali (Callback) Terhadap Panggilan yang Tidak Terjawab (Missed Call) di Unit Callcenter	100.00	\N	\N	lebih_besar	aktif	37	77	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
111	Kepatuhan Penempatan Pasien Di Ruang Isolasi Sesuai Indikasi	100.00	\N	\N	lebih_besar	aktif	35	111	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
112	Kepatuhan petugas memilah limbah medis sesuai jenisnya di unit pelayanan	100.00	\N	\N	lebih_besar	aktif	35	112	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
113	Pencatatan Suhu Area Instalasi Gizi	100.00	\N	\N	lebih_besar	aktif	35	113	\N	2026-01-01 00:00:00	2026-01-01 00:00:00
76	Waktu Tunggu Pelayanan Pendaftaran Pasien Poliklinik Rawat Jalan Dengan Penjaminan Assuransi/Perusahaaan < 15 Menit	100.00	\N	\N	lebih_besar	aktif	37	76	\N	2026-01-01 00:00:00	2026-04-15 08:38:31
44	Prosentase Klaim Pending	5.00	\N	\N	lebih_kecil	aktif	26	44	\N	2026-01-01 00:00:00	2026-04-15 08:42:49
50	Keberhasilan Perawat Dalam Pemasangan Infus satu Kali pada pasien rawat Inap	90.00	\N	\N	lebih_besar	aktif	50	50	\N	2026-01-01 00:00:00	2026-04-15 08:47:03
67	Kelengkapan Pengisian Informed Concent Setelah Mendapatkan Informasi Yang Jelas	100.00	\N	\N	lebih_besar	aktif	41	67	\N	2026-01-01 00:00:00	2026-04-15 08:57:58
115	Kelengkapan PCRA dan ICRA pada setiap Renovasi di RS Azra	100.00	\N	\N	lebih_besar	aktif	4	115	\N	2026-01-01 00:00:00	2026-04-15 09:03:51
116	Kecepatan waktu pelaporan kecelakaan kerja staf RS Azra kurang dari 2 x 24 jam	90.00	\N	\N	lebih_besar	aktif	4	116	\N	2026-01-01 00:00:00	2026-04-15 09:04:08
117	Angka keterampilan staf dalam penggunaan APAR	80.00	\N	\N	lebih_besar	aktif	4	117	\N	2026-01-01 00:00:00	2026-04-15 09:04:19
20	Tidak ada kesalahan cara pemberian obat elektrolit konsentrat di Rawat Inap dan Intensif	100.00	\N	\N	lebih_besar	aktif	17	20	\N	2026-01-01 00:00:00	2026-04-16 03:56:36
118	BOR (Bed Occupancy Rate)	60.00	\N	\N	lebih_besar	aktif	41	119	\N	2026-01-16 04:02:23	2026-04-16 04:09:42
\.


--
-- Data for Name: tbl_indikator_periode; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_indikator_periode (id, indikator_id, periode_id, status, created_at, updated_at) FROM stdin;
1	2	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
2	3	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
3	4	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
4	5	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
5	6	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
6	7	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
7	8	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
8	9	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
9	10	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
10	12	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
11	13	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
12	14	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
13	15	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
14	16	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
15	17	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
16	18	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
17	19	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
18	20	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
19	22	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
20	23	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
21	24	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
22	25	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
23	26	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
24	27	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
25	28	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
26	29	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
27	30	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
28	31	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
29	32	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
30	33	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
31	34	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
32	35	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
33	36	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
34	37	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
35	38	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
36	39	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
37	40	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
38	41	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
39	42	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
40	43	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
41	44	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
42	45	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
43	46	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
44	47	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
45	48	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
46	49	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
47	50	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
48	51	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
49	52	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
50	54	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
51	55	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
52	56	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
53	57	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
54	59	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
55	60	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
56	61	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
57	62	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
58	64	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
59	65	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
60	66	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
61	67	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
62	68	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
63	69	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
64	70	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
65	71	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
66	72	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
67	73	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
68	74	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
69	75	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
70	76	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
71	78	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
72	79	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
73	80	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
74	81	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
75	82	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
76	83	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
77	84	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
78	85	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
79	86	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
80	87	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
81	88	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
82	89	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
83	90	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
84	91	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
85	92	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
86	93	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
87	94	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
88	95	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
89	96	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
90	97	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
91	98	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
92	99	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
93	100	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
94	101	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
95	102	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
96	103	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
97	104	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
98	105	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
99	106	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
100	107	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
101	108	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
102	109	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
103	110	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
104	1	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
105	11	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
106	21	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
107	53	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
108	58	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
109	63	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
110	77	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
111	111	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
112	112	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
113	113	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
114	114	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
115	115	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
116	116	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
117	117	1	aktif	2026-01-01 00:00:00	2026-01-01 00:00:00
118	118	1	aktif	2026-01-16 04:02:23	2026-01-16 04:02:23
\.


--
-- Data for Name: tbl_jenis_indikator; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_jenis_indikator (id, nama_jenis_indikator, created_at, updated_at) FROM stdin;
1	Struktur	\N	\N
2	Proses	\N	\N
3	Output	\N	\N
4	Outcome	\N	\N
\.


--
-- Data for Name: tbl_kamus_indikator; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_kamus_indikator (id, indikator_id, kategori_indikator, kategori_id, dimensi_mutu_id, dasar_pemikiran, tujuan, definisi_operasional, jenis_indikator_id, satuan_pengukuran, numerator, denominator, target_pencapaian, kriteria_inklusi, kriteria_eksklusi, formula, metode_pengumpulan_data, sumber_data, instrumen_pengambilan_data, populasi, sampel, periode_pengumpulan_data_id, periode_analisis_data_id, penyajian_data_id, penanggung_jawab, created_at, updated_at) FROM stdin;
1	1	Nasional	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
2	2	Nasional	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
3	3	Nasional	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
4	4	Nasional	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
5	5	Nasional	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
6	6	Nasional	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
7	7	Nasional	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
8	8	Nasional	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
9	9	Nasional	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
10	10	Nasional	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
11	11	Nasional	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
12	12	Nasional	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
13	13	Nasional	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
31	31	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
32	32	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
33	33	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
34	34	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
35	35	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
36	36	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
37	37	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
38	38	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
40	40	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
42	42	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
43	43	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
44	44	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
45	45	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
39	39	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-15 09:52:07
28	28	Prioritas RS	10	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-16 01:27:32
23	23	Prioritas RS	7	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-16 01:30:32
29	29	Prioritas RS	10	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-16 01:21:12
22	22	Prioritas RS	6	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-16 01:21:28
24	24	Prioritas RS	8	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-16 01:22:10
25	25	Prioritas RS	8	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-16 01:22:21
19	19	Prioritas RS	3	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-16 01:23:04
26	26	Prioritas RS	9	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-16 01:23:19
27	27	Prioritas RS	9	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-16 01:23:33
17	17	Prioritas RS	2	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-16 01:25:32
14	14	Prioritas RS	2	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-16 01:25:45
16	16	Prioritas RS	2	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-16 01:25:55
15	15	Prioritas RS	2	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-16 01:26:05
18	18	Prioritas RS	2	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-16 01:26:19
21	21	Prioritas RS	5	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-16 01:26:34
20	20	Prioritas RS	4	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-16 01:30:05
46	46	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
47	47	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
48	48	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
49	49	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
50	50	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
51	51	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
52	52	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
53	53	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
54	54	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
55	55	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
56	56	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
57	57	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
58	58	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
59	59	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
61	61	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
62	62	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
64	64	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
65	65	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
66	66	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
70	70	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
71	71	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
73	73	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
74	74	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
75	75	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
76	76	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
77	77	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
79	79	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
81	81	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
83	83	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
84	84	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
85	85	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
86	86	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
87	87	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
89	89	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
90	90	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
63	63	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-15 09:53:05
67	67	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-15 09:53:28
82	82	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-15 09:54:51
60	60	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-15 09:54:03
68	68	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-15 09:53:39
69	69	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-15 09:53:50
88	88	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-15 09:55:06
80	80	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-15 09:58:48
78	78	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-15 09:50:59
91	91	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
92	92	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
94	94	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
95	95	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
98	98	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
100	100	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
103	103	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
105	105	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
106	106	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
108	108	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
109	109	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
110	110	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
111	111	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
112	112	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
113	113	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
115	115	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
116	116	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
117	117	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-01-01 00:00:00
107	107	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-15 09:50:17
99	99	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-15 09:50:36
41	41	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-15 09:51:22
93	93	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-15 09:55:19
104	104	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-15 09:49:25
102	102	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-15 09:49:40
101	101	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-15 09:50:05
97	97	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-16 01:24:28
72	72	Prioritas Unit	\N	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-16 01:25:04
30	30	Prioritas RS	11	1	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-01-01 00:00:00	2026-04-16 01:27:15
96	96	Prioritas Unit	\N	2	adapun dasar pemikiran adalah sebagai berikut :\r\n- SIMRS adalah sistem kritikal (mission critical), \r\n- Menjamin kontinuitas pelayanan rumah sakit,\r\n- Meningkatkan kepuasan pengguna (user satisfaction), \r\n- Selaras dengan prinsip mutu dan akreditasi rumah sakit\r\n\r\nSedangkan dasar hukumnya adalah sebagai berikut :\r\n- Undang-Undang Nomor 36 Tahun 2009 tentang Kesehatan\r\n- Peraturan Menteri Kesehatan Nomor 82 Tahun 2013 tentang Sistem Informasi Manajemen Rumah Sakit\r\n- Peraturan Menteri Kesehatan Nomor 24 Tahun 2022 tentang Rekam Medis\r\n- Standar Akreditasi Rumah Sakit – Komisi Akreditasi Rumah Sakit (KARS / SNARS)	Terlaksananya pelayanan SIMRS yang cepat dan tepat	Respontime terhadap penerimaan laporan maksimal 10 menit pada jam kerja	3	Persentase (%)	Jumlah permintaan perbaikan yang direspon < 10 menit	Jumlah permintaan perbaikan yang masuk	90%	Semua permintaan perbaikan fasilitas SIMRS (error ringan, akses, printer, jaringan lokal SIMRS)	Gangguan besar (major incident)\r\nPerbaikan yang membutuhkan vendor eksternal\r\nPermintaan pengembangan sistem (bukan perbaikan)	(Numerator/Denuminator) x 100%	Sensus Harian	Log helpdesk / tiket IT\r\nSistem ticketing SIMRS\r\nLaporan tim IT support	Mengambil data waktu mulai (tiket dibuat) dan waktu selesai (tiket closed) dari sistem helpdesk atau log manual.	unit pengguna komputer	All	1	1	2	Tim IT / Unit SIMRS	2026-01-01 00:00:00	2026-04-16 03:55:12
119	118	Prioritas Unit	\N	4	test	test	test	1	test	test	test	test	test	test	test	test	test	test	test	test	1	1	1	test	2026-04-16 04:03:31	2026-04-16 04:03:31
\.


--
-- Data for Name: tbl_kategori_imprs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_kategori_imprs (id, nama_kategori_imprs, created_at, updated_at) FROM stdin;
1	Sasaran Keselamatan Pasien (SKP)	\N	\N
2	Identifikasi Pasien	\N	\N
3	Komunikasi Efektif	\N	\N
4	Keamanan Obat	\N	\N
5	Tepat Lokasi dan Prosedur	\N	\N
6	Risiko Infeksi	\N	\N
7	Risiko Jatuh	\N	\N
8	Pelayanan Klinis Prioritas	\N	\N
9	Tujuan Strategis RS	\N	\N
10	Perbaikan Sistem Lintas Unit	\N	\N
11	Manajemen Resiko	\N	\N
\.


--
-- Data for Name: tbl_laporan_dan_analis; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_laporan_dan_analis (id, tanggal_laporan, indikator_id, nilai_validator, unit_id, kategori_indikator, kategori_id, numerator, denominator, nilai, pencapaian, status_laporan, file_laporan, target_saat_input, target_min_saat_input, target_max_saat_input, arah_target_saat_input, created_at, updated_at) FROM stdin;
32	2026-01-01	96	97.48	23	\N	\N	0	0	\N	N/A	valid	\N	90.00	\N	\N	lebih_besar	2026-04-16 03:59:42	2026-04-16 04:04:03
78	2026-01-13	47	\N	17	\N	\N	0	0	\N	N/A	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 05:18:02	2026-04-16 05:18:02
66	2026-01-01	47	\N	17	\N	\N	0	0	\N	N/A	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 05:16:58	2026-04-16 05:18:02
69	2026-01-04	47	\N	17	\N	\N	0	0	\N	N/A	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 05:17:14	2026-04-16 05:18:02
72	2026-01-07	47	\N	17	\N	\N	0	0	\N	N/A	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 05:17:29	2026-04-16 05:18:02
75	2026-01-10	47	\N	17	\N	\N	0	0	\N	N/A	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 05:17:46	2026-04-16 05:18:02
97	2026-04-08	99	\N	47	\N	\N	3	3	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 06:09:03	2026-04-16 06:13:00
95	2026-04-06	99	\N	47	\N	\N	2	2	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 06:08:42	2026-04-16 06:13:00
100	2026-04-14	99	\N	47	\N	\N	1	1	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 06:13:00	2026-04-16 06:13:00
28	2026-01-28	48	\N	22	\N	\N	0	1	0.00	tercapai	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 03:04:01	2026-04-16 03:04:20
24	2026-01-24	48	\N	22	\N	\N	0	2	0.00	tercapai	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 03:02:58	2026-04-16 03:04:20
12	2026-01-12	48	\N	22	\N	\N	0	2	0.00	tercapai	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 02:59:02	2026-04-16 03:04:20
1	2026-01-01	48	\N	22	\N	\N	0	0	\N	N/A	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 02:40:05	2026-04-16 03:04:20
2	2026-01-02	48	\N	22	\N	\N	0	0	\N	N/A	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 02:56:16	2026-04-16 03:04:20
3	2026-01-03	48	\N	22	\N	\N	0	0	\N	N/A	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 02:56:36	2026-04-16 03:04:20
4	2026-01-04	48	\N	22	\N	\N	0	0	\N	N/A	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 02:56:47	2026-04-16 03:04:20
5	2026-01-05	48	\N	22	\N	\N	0	0	\N	N/A	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 02:57:13	2026-04-16 03:04:20
6	2026-01-06	48	\N	22	\N	\N	0	0	\N	N/A	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 02:57:21	2026-04-16 03:04:20
7	2026-01-07	48	\N	22	\N	\N	0	0	\N	N/A	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 02:57:28	2026-04-16 03:04:20
27	2026-01-27	48	\N	22	\N	\N	0	1	0.00	tercapai	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 03:03:38	2026-04-16 03:04:20
31	2026-01-31	48	\N	22	\N	\N	0	1	0.00	tercapai	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 03:04:20	2026-04-16 03:04:20
53	2026-02-02	99	\N	47	\N	\N	2	2	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:55:34	2026-04-16 04:58:34
56	2026-02-05	99	\N	47	\N	\N	3	3	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:56:00	2026-04-16 04:58:34
46	2026-01-21	99	\N	47	\N	\N	1	1	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:52:01	2026-04-16 04:53:14
34	2026-01-02	99	\N	47	\N	\N	3	3	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:40:40	2026-04-16 04:53:14
37	2026-01-07	99	\N	47	\N	\N	3	3	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:47:08	2026-04-16 04:53:14
40	2026-01-12	99	\N	47	\N	\N	3	3	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:50:56	2026-04-16 04:53:14
43	2026-01-15	99	\N	47	\N	\N	1	1	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:51:18	2026-04-16 04:53:14
49	2026-01-27	99	\N	47	\N	\N	1	1	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:52:47	2026-04-16 04:53:14
52	2026-01-30	99	\N	47	\N	\N	1	1	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:53:14	2026-04-16 04:53:14
59	2026-02-11	99	\N	47	\N	\N	1	1	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:56:33	2026-04-16 04:58:34
62	2026-02-16	99	\N	47	\N	\N	2	2	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:57:08	2026-04-16 04:58:34
65	2026-02-26	99	\N	47	\N	\N	1	1	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:58:34	2026-04-16 04:58:34
89	2026-03-24	99	\N	47	\N	\N	3	3	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 06:06:11	2026-04-16 06:07:13
81	2026-03-04	99	\N	47	\N	\N	1	1	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 06:04:26	2026-04-16 06:07:13
84	2026-03-10	99	\N	47	\N	\N	2	2	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 06:04:59	2026-04-16 06:07:13
87	2026-03-17	99	\N	47	\N	\N	3	3	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 06:05:38	2026-04-16 06:07:13
92	2026-03-31	99	\N	47	\N	\N	3	3	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 06:06:54	2026-04-16 06:07:13
33	2026-01-02	96	97.48	23	\N	\N	9	9	100.00	tercapai	valid	\N	90.00	\N	\N	lebih_besar	2026-04-16 03:59:47	2026-04-16 04:04:03
67	2026-01-02	47	\N	17	\N	\N	0	0	\N	N/A	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 05:17:04	2026-04-16 05:18:02
70	2026-01-05	47	\N	17	\N	\N	0	0	\N	N/A	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 05:17:19	2026-04-16 05:18:02
73	2026-01-08	47	\N	17	\N	\N	0	0	\N	N/A	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 05:17:34	2026-04-16 05:18:02
76	2026-01-11	47	\N	17	\N	\N	0	0	\N	N/A	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 05:17:51	2026-04-16 05:18:02
8	2026-01-08	48	\N	22	\N	\N	0	0	\N	N/A	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 02:57:37	2026-04-16 03:04:20
9	2026-01-09	48	\N	22	\N	\N	0	3	0.00	tercapai	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 02:58:25	2026-04-16 03:04:20
10	2026-01-10	48	\N	22	\N	\N	0	4	0.00	tercapai	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 02:58:34	2026-04-16 03:04:20
11	2026-01-11	48	\N	22	\N	\N	0	5	0.00	tercapai	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 02:58:48	2026-04-16 03:04:20
13	2026-01-13	48	\N	22	\N	\N	0	2	0.00	tercapai	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 03:00:52	2026-04-16 03:04:20
93	2026-04-01	99	\N	47	\N	\N	1	1	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 06:07:54	2026-04-16 06:13:00
96	2026-04-07	99	\N	47	\N	\N	2	2	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 06:08:53	2026-04-16 06:13:00
98	2026-04-09	99	\N	47	\N	\N	3	3	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 06:09:18	2026-04-16 06:13:00
54	2026-02-03	99	\N	47	\N	\N	1	1	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:55:40	2026-04-16 04:58:34
57	2026-02-06	99	\N	47	\N	\N	2	2	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:56:06	2026-04-16 04:58:34
60	2026-02-12	99	\N	47	\N	\N	1	1	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:56:38	2026-04-16 04:58:34
63	2026-02-24	99	\N	47	\N	\N	1	1	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:58:17	2026-04-16 04:58:34
14	2026-01-14	48	\N	22	\N	\N	0	1	0.00	tercapai	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 03:01:11	2026-04-16 03:04:20
15	2026-01-15	48	\N	22	\N	\N	0	1	0.00	tercapai	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 03:01:24	2026-04-16 03:04:20
16	2026-01-16	48	\N	22	\N	\N	0	0	\N	N/A	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 03:01:39	2026-04-16 03:04:20
17	2026-01-17	48	\N	22	\N	\N	0	0	\N	N/A	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 03:01:46	2026-04-16 03:04:20
25	2026-01-25	48	\N	22	\N	\N	0	1	0.00	tercapai	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 03:03:09	2026-04-16 03:04:20
29	2026-01-29	48	\N	22	\N	\N	0	1	0.00	tercapai	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 03:04:07	2026-04-16 03:04:20
35	2026-01-05	99	\N	47	\N	\N	1	1	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:41:25	2026-04-16 04:53:14
38	2026-01-08	99	\N	47	\N	\N	4	4	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:47:57	2026-04-16 04:53:14
41	2026-01-13	99	\N	47	\N	\N	2	2	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:51:04	2026-04-16 04:53:14
44	2026-01-19	99	\N	47	\N	\N	3	3	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:51:38	2026-04-16 04:53:14
47	2026-01-22	99	\N	47	\N	\N	2	2	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:52:12	2026-04-16 04:53:14
50	2026-01-28	99	\N	47	\N	\N	2	2	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:52:58	2026-04-16 04:53:14
79	2026-03-02	99	\N	47	\N	\N	3	3	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 06:04:10	2026-04-16 06:07:13
82	2026-03-06	99	\N	47	\N	\N	3	3	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 06:04:33	2026-04-16 06:07:13
85	2026-03-11	99	\N	47	\N	\N	1	1	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 06:05:05	2026-04-16 06:07:13
88	2026-03-18	99	\N	47	\N	\N	1	1	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 06:05:47	2026-04-16 06:07:13
90	2026-03-25	99	\N	47	\N	\N	1	1	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 06:06:22	2026-04-16 06:07:13
68	2026-01-03	47	\N	17	\N	\N	0	0	\N	N/A	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 05:17:09	2026-04-16 05:18:02
71	2026-01-06	47	\N	17	\N	\N	0	0	\N	N/A	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 05:17:24	2026-04-16 05:18:02
74	2026-01-09	47	\N	17	\N	\N	0	0	\N	N/A	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 05:17:40	2026-04-16 05:18:02
77	2026-01-12	47	\N	17	\N	\N	0	0	\N	N/A	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 05:17:57	2026-04-16 05:18:02
18	2026-01-18	48	\N	22	\N	\N	0	0	\N	N/A	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 03:01:53	2026-04-16 03:04:20
19	2026-01-19	48	\N	22	\N	\N	0	0	\N	N/A	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 03:01:59	2026-04-16 03:04:20
94	2026-04-02	99	\N	47	\N	\N	1	1	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 06:08:00	2026-04-16 06:13:00
99	2026-04-10	99	\N	47	\N	\N	1	1	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 06:09:25	2026-04-16 06:13:00
20	2026-01-20	48	\N	22	\N	\N	0	0	\N	N/A	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 03:02:07	2026-04-16 03:04:20
21	2026-01-21	48	\N	22	\N	\N	0	0	\N	N/A	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 03:02:13	2026-04-16 03:04:20
22	2026-01-22	48	\N	22	\N	\N	0	1	0.00	tercapai	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 03:02:31	2026-04-16 03:04:20
23	2026-01-23	48	\N	22	\N	\N	0	1	0.00	tercapai	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 03:02:39	2026-04-16 03:04:20
26	2026-01-26	48	\N	22	\N	\N	0	2	0.00	tercapai	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 03:03:24	2026-04-16 03:04:20
30	2026-01-30	48	\N	22	\N	\N	0	1	0.00	tercapai	\N	\N	0.00	\N	\N	lebih_kecil	2026-04-16 03:04:13	2026-04-16 03:04:20
55	2026-02-04	99	\N	47	\N	\N	2	2	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:55:52	2026-04-16 04:58:34
58	2026-02-09	99	\N	47	\N	\N	3	3	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:56:25	2026-04-16 04:58:34
61	2026-02-13	99	\N	47	\N	\N	3	3	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:56:45	2026-04-16 04:58:34
64	2026-02-25	99	\N	47	\N	\N	2	2	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:58:26	2026-04-16 04:58:34
36	2026-01-06	99	\N	47	\N	\N	2	2	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:41:44	2026-04-16 04:53:14
39	2026-01-09	99	\N	47	\N	\N	2	2	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:50:15	2026-04-16 04:53:14
42	2026-01-14	99	\N	47	\N	\N	2	2	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:51:11	2026-04-16 04:53:14
45	2026-01-20	99	\N	47	\N	\N	1	1	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:51:52	2026-04-16 04:53:14
48	2026-01-26	99	\N	47	\N	\N	1	1	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:52:39	2026-04-16 04:53:14
51	2026-01-29	99	\N	47	\N	\N	3	3	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 04:53:07	2026-04-16 04:53:14
80	2026-03-03	99	\N	47	\N	\N	1	1	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 06:04:17	2026-04-16 06:07:13
83	2026-03-09	99	\N	47	\N	\N	1	1	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 06:04:53	2026-04-16 06:07:13
86	2026-03-16	99	\N	47	\N	\N	3	3	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 06:05:25	2026-04-16 06:07:13
91	2026-03-30	99	\N	47	\N	\N	1	1	100.00	tercapai	\N	\N	80.00	\N	\N	lebih_besar	2026-04-16 06:06:44	2026-04-16 06:07:13
\.


--
-- Data for Name: tbl_laporan_validator; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_laporan_validator (id, tanggal_laporan, indikator_id, laporan_analis_id, unit_id, kategori_indikator, kategori_id, numerator, denominator, nilai_validator, pencapaian, status_laporan, file_laporan, target_saat_input, target_min_saat_input, target_max_saat_input, arah_target_saat_input, created_at, updated_at) FROM stdin;
1	2026-01-01	96	32	23	\N	\N	0	0	\N	N/A	\N	\N	\N	\N	\N	\N	2026-04-16 04:00:19	2026-04-16 04:00:19
2	2026-01-02	96	32	23	\N	\N	9	9	100.00	tercapai	\N	\N	\N	\N	\N	\N	2026-04-16 04:00:24	2026-04-16 04:00:24
3	2026-01-03	96	32	23	\N	\N	3	3	100.00	tercapai	\N	\N	\N	\N	\N	\N	2026-04-16 04:00:31	2026-04-16 04:00:31
4	2026-01-04	96	32	23	\N	\N	0	0	\N	N/A	\N	\N	\N	\N	\N	\N	2026-04-16 04:00:45	2026-04-16 04:00:45
5	2026-01-05	96	32	23	\N	\N	4	4	100.00	tercapai	\N	\N	\N	\N	\N	\N	2026-04-16 04:00:52	2026-04-16 04:00:52
6	2026-01-06	96	32	23	\N	\N	4	4	100.00	tercapai	\N	\N	\N	\N	\N	\N	2026-04-16 04:00:59	2026-04-16 04:00:59
7	2026-01-07	96	32	23	\N	\N	3	3	100.00	tercapai	\N	\N	\N	\N	\N	\N	2026-04-16 04:01:05	2026-04-16 04:01:05
8	2026-01-08	96	32	23	\N	\N	5	5	100.00	tercapai	\N	\N	\N	\N	\N	\N	2026-04-16 04:01:14	2026-04-16 04:01:14
9	2026-01-09	96	32	23	\N	\N	6	6	100.00	tercapai	\N	\N	\N	\N	\N	\N	2026-04-16 04:01:26	2026-04-16 04:01:26
10	2026-01-10	96	32	23	\N	\N	0	0	\N	N/A	\N	\N	\N	\N	\N	\N	2026-04-16 04:01:32	2026-04-16 04:01:32
11	2026-01-11	96	32	23	\N	\N	0	0	\N	N/A	\N	\N	\N	\N	\N	\N	2026-04-16 04:01:39	2026-04-16 04:01:39
12	2026-01-12	96	32	23	\N	\N	9	9	100.00	tercapai	\N	\N	\N	\N	\N	\N	2026-04-16 04:01:52	2026-04-16 04:01:52
13	2026-01-13	96	32	23	\N	\N	6	6	100.00	tercapai	\N	\N	\N	\N	\N	\N	2026-04-16 04:01:59	2026-04-16 04:01:59
14	2026-01-14	96	32	23	\N	\N	7	7	100.00	tercapai	\N	\N	\N	\N	\N	\N	2026-04-16 04:02:05	2026-04-16 04:02:05
15	2026-01-15	96	32	23	\N	\N	1	1	100.00	tercapai	\N	\N	\N	\N	\N	\N	2026-04-16 04:02:10	2026-04-16 04:02:10
16	2026-01-16	96	32	23	\N	\N	0	0	\N	N/A	\N	\N	\N	\N	\N	\N	2026-04-16 04:02:17	2026-04-16 04:02:17
17	2026-01-17	96	32	23	\N	\N	2	2	100.00	tercapai	\N	\N	\N	\N	\N	\N	2026-04-16 04:02:22	2026-04-16 04:02:22
18	2026-01-18	96	32	23	\N	\N	0	0	\N	N/A	\N	\N	\N	\N	\N	\N	2026-04-16 04:02:30	2026-04-16 04:02:30
19	2026-01-19	96	32	23	\N	\N	7	8	87.50	tidak-tercapai	\N	\N	\N	\N	\N	\N	2026-04-16 04:02:38	2026-04-16 04:02:38
20	2026-01-20	96	32	23	\N	\N	1	1	100.00	tercapai	\N	\N	\N	\N	\N	\N	2026-04-16 04:02:44	2026-04-16 04:02:44
21	2026-01-21	96	32	23	\N	\N	1	1	100.00	tercapai	\N	\N	\N	\N	\N	\N	2026-04-16 04:02:51	2026-04-16 04:02:51
22	2026-01-22	96	32	23	\N	\N	0	0	\N	N/A	\N	\N	\N	\N	\N	\N	2026-04-16 04:02:59	2026-04-16 04:02:59
23	2026-01-23	96	32	23	\N	\N	5	5	100.00	tercapai	\N	\N	\N	\N	\N	\N	2026-04-16 04:03:10	2026-04-16 04:03:10
24	2026-01-24	96	32	23	\N	\N	6	6	100.00	tercapai	\N	\N	\N	\N	\N	\N	2026-04-16 04:03:21	2026-04-16 04:03:21
25	2026-01-25	96	32	23	\N	\N	0	0	\N	N/A	\N	\N	\N	\N	\N	\N	2026-04-16 04:03:27	2026-04-16 04:03:27
26	2026-01-26	96	32	23	\N	\N	5	5	100.00	tercapai	\N	\N	\N	\N	\N	\N	2026-04-16 04:03:33	2026-04-16 04:03:33
27	2026-01-27	96	32	23	\N	\N	3	3	100.00	tercapai	\N	\N	\N	\N	\N	\N	2026-04-16 04:03:39	2026-04-16 04:03:39
28	2026-01-28	96	32	23	\N	\N	4	7	57.14	tidak-tercapai	\N	\N	\N	\N	\N	\N	2026-04-16 04:03:45	2026-04-16 04:03:45
29	2026-01-29	96	32	23	\N	\N	5	5	100.00	tercapai	\N	\N	\N	\N	\N	\N	2026-04-16 04:03:52	2026-04-16 04:03:52
30	2026-01-30	96	32	23	\N	\N	4	4	100.00	tercapai	\N	\N	\N	\N	\N	\N	2026-04-16 04:03:57	2026-04-16 04:03:57
31	2026-01-31	96	32	23	\N	\N	0	0	\N	N/A	\N	\N	\N	\N	\N	\N	2026-04-16 04:04:03	2026-04-16 04:04:03
\.


--
-- Data for Name: tbl_metode_pengumpulan_data; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_metode_pengumpulan_data (id, nama_metode_pengumpulan_data, created_at, updated_at) FROM stdin;
1	Sensus Harian	\N	\N
2	Retrospektif	\N	\N
\.


--
-- Data for Name: tbl_pdsa; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_pdsa (id, assignment_id, plan, "do", study, action, created_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: tbl_pdsa_assignments; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_pdsa_assignments (id, indikator_id, unit_id, tahun, quarter, catatan_mutu, status_pdsa, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: tbl_penyajian_data; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_penyajian_data (id, nama_penyajian_data, created_at, updated_at) FROM stdin;
1	Statistik	\N	\N
2	Run Chart	\N	\N
3	Control Chart	\N	\N
4	Pareto	\N	\N
5	Bar Diagram	\N	\N
\.


--
-- Data for Name: tbl_periode; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_periode (id, nama_periode, tahun, tanggal_mulai, tanggal_selesai, deadline, status_deadline, status, created_at, updated_at) FROM stdin;
1	Periode Mutu 2026	2026	2026-01-01	2026-12-31	5	f	aktif	2026-04-15 08:29:31	2026-04-15 08:29:31
\.


--
-- Data for Name: tbl_periode_analisis_data; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_periode_analisis_data (id, nama_periode_analisis_data, created_at, updated_at) FROM stdin;
1	Bulanan	\N	\N
2	Triwulanan	\N	\N
3	Tahunan	\N	\N
\.


--
-- Data for Name: tbl_periode_pengumpulan_data; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_periode_pengumpulan_data (id, nama_periode_pengumpulan_data, created_at, updated_at) FROM stdin;
1	Harian	\N	\N
2	Mingguan	\N	\N
3	Bulanan	\N	\N
\.


--
-- Data for Name: tbl_periode_unit_deadline; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_periode_unit_deadline (id, periode_id, unit_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: tbl_role; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_role (id, nama_role, deskripsi_role, created_at, updated_at) FROM stdin;
1	Administrator	Memiliki akses penuh ke semua fitur dan pengaturan sistem.	\N	\N
2	Tim Mutu	Bertanggung jawab atas manajemen unit dan pelaporan indikator mutu.	\N	\N
3	Validator	Menginput dan melaporkan data indikator sesuai unit masing-masing.	\N	\N
4	Staff	Pelaksana	\N	\N
5	Koordinator	Leader Ruangan	\N	\N
6	Penanggung Jawab	PJ Shift / PJ Layanan	\N	\N
7	Supervisor	Leader Lintas Unit	\N	\N
8	Kepala unit	Manager Unit	\N	\N
9	Kepala	Kepala Divisi / Kepala Bagian	\N	\N
10	Dokter Spesialis	Dokter Spesialis	\N	\N
\.


--
-- Data for Name: tbl_unit; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_unit (id, kode_unit, nama_unit, deskripsi_unit, status_unit, created_at, updated_at) FROM stdin;
1	UNIT001	Administrator	\N	aktif	\N	\N
2	UNIT002	Mutu	\N	aktif	\N	\N
6	UNIT006	IPSRS	\N	aktif	\N	\N
7	UNIT007	Rawat jalan	\N	aktif	\N	\N
9	UNIT009	Transportasi & kurir	\N	aktif	\N	\N
10	UNIT010	NS 1	\N	aktif	\N	\N
11	UNIT011	NS 2	\N	aktif	\N	\N
12	UNIT012	NS 3	\N	aktif	\N	\N
13	UNIT013	NS 4	\N	aktif	\N	\N
14	UNIT014	NS 6	\N	aktif	\N	\N
15	UNIT015	NS 7	\N	aktif	\N	\N
16	UNIT016	NS 8	\N	aktif	\N	\N
17	UNIT017	ICU	\N	aktif	\N	\N
18	UNIT018	Instalasi gawat darurat	\N	aktif	\N	\N
20	UNIT020	Marketing	\N	aktif	\N	\N
22	UNIT022	NICU & PICU	\N	aktif	\N	\N
23	UNIT023	IT	\N	aktif	\N	\N
24	UNIT024	Sekretariat	\N	aktif	\N	\N
25	UNIT025	MPP	\N	aktif	\N	\N
26	UNIT026	Casemix	\N	aktif	\N	\N
27	UNIT027	Kamar operasi	\N	aktif	\N	\N
31	UNIT031	Maintenance	\N	aktif	\N	\N
32	UNIT032	Dokter jaga	\N	aktif	\N	\N
33	UNIT033	Hemodialisa	\N	aktif	\N	\N
35	UNIT035	PPI	\N	aktif	\N	\N
36	UNIT036	SDM	\N	aktif	\N	\N
37	UNIT037	AO & Call center	\N	aktif	\N	\N
38	UNIT038	Perinatologi	\N	aktif	\N	\N
39	UNIT039	CSSD	\N	aktif	\N	\N
41	UNIT041	Rekam medis	\N	aktif	\N	\N
42	UNIT042	Instalasi kamar operasi	\N	aktif	\N	\N
43	UNIT043	Keuangan	\N	aktif	\N	\N
44	UNIT044	Kamar bersalin	\N	aktif	\N	\N
45	UNIT045	Rawat inap	\N	aktif	\N	\N
46	UNIT046	Kesehatan lingkungan	\N	aktif	\N	\N
47	UNIT047	Legal	\N	aktif	\N	\N
48	UNIT048	Logistik umum	\N	aktif	\N	\N
49	UNIT049	Duty officer	\N	aktif	\N	\N
51	UNIT051	Laundry	\N	aktif	\N	\N
52	UNIT052	AR	\N	aktif	\N	\N
40	UNIT040	Akuntansi	\N	aktif	\N	2026-04-15 08:35:14
30	UNIT030	Kasir & Pentarifan	\N	aktif	\N	2026-04-15 08:35:58
28	UNIT028	Pengadaan	\N	aktif	\N	2026-04-15 08:36:34
54	UNIT054	Sales & Digital Marketing	\N	aktif	2026-04-15 08:40:29	2026-04-15 08:40:29
21	UNIT021	Farmasi	\N	aktif	\N	2026-04-15 08:51:36
50	UNIT050	Keperawatan	\N	aktif	\N	2026-04-15 08:51:56
3	UNIT003	Gizi	\N	aktif	\N	2026-04-15 08:53:21
8	UNIT008	Laboratorium	\N	aktif	\N	2026-04-15 08:54:30
34	UNIT034	Radiologi	\N	aktif	\N	2026-04-15 08:55:23
29	UNIT029	Rehabilitasi Medik & KTKA	\N	aktif	\N	2026-04-15 08:57:09
4	UNIT004	Rumah Tangga & K3RS	\N	aktif	\N	2026-04-15 09:01:59
5	UNIT005	Umum & Perizinan	\N	aktif	\N	2026-04-15 09:05:11
55	UNIT055	Intensif	\N	aktif	2026-04-15 08:49:38	2026-04-16 01:32:11
19	UNIT019	KTKA	\N	non-aktif	\N	2026-04-16 02:43:17
53	UNIT053	Humas & CC	\N	aktif	2026-04-15 08:39:08	2026-04-16 03:16:08
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, nama_lengkap, nip, username, email, email_verified_at, password, role_id, unit_id, profesi, atasan_langsung, status_user, remember_token, created_at, updated_at) FROM stdin;
1	Administrator	1234567890	admin	administrator@rsazra.co.id	\N	$2y$12$YAwqcds7ch4ySDiSp7nhButhqF7xE2JTQqqbGDkSyq.4pcHkJqZ02	1	1	Non Medis	Direktur Utama	aktif	\N	2026-04-15 08:29:31	2026-04-15 08:29:31
2	Mutu	0987654321	mutu	mutu@rsazra.co.id	\N	$2y$12$yW7YGHYiSFjOiwJ5sUbwk.gikTY1BH8Sd4Js9JAqiaKvSoC6h.C06	2	2	Medis	Ketua Komite Mutu	aktif	\N	2026-04-15 08:29:32	2026-04-15 08:29:32
4	GARCINIA SATIVA FIZRIA SETIADI, DR., MKM	20061005	garcinia.sativa	garcinia.sativa@rsazra.co.id	\N	$2y$12$UT7Tlr7bDy55eOAPEjnahO8vYSgjWaitXyRJ/s8Ms8LrWpkdPhBGG	9	1	Medis	MANAGER	aktif	\N	2026-04-15 08:29:32	2026-04-15 08:29:32
5	INDRA THALIB, BSN., MM	20253017	indra.thalib	indra.thalib@rsazra.co.id	\N	$2y$12$n57q.htYOrFXwCn.yS5VyeCGMdah4gaROEmAQeQvDKHnQa2AuunGe	9	36	Non Medis	MANAGER	aktif	\N	2026-04-15 08:29:32	2026-04-15 08:29:32
6	IRMA RISMAYANTY, DR., MM	20253030	irma.rismayanty	irma.rismayanty@rsazra.co.id	\N	$2y$12$YN415mzA.XplgmS6zlH/pO.ws35CRPzirQc04dQKHG0W2Nf9ZXBEK	9	1	Non Medis	DIREKTUR	aktif	\N	2026-04-15 08:29:32	2026-04-15 08:29:32
7	LAILA AZRA, DRA.	19950015	laila.azra	laila.azra@rsazra.co.id	\N	$2y$12$ewvM0SIBMq4UOdAMp.zh.eJxD9gGu6.7mfGLNrbDhGlwwUyRIc82S	9	1	Non Medis	PRESIDEN KOMISARIS	aktif	\N	2026-04-15 08:29:33	2026-04-15 08:29:33
8	LILI MARLIANI, DR., MARS	20253062	lili.marliani	lili.marliani@rsazra.co.id	\N	$2y$12$9VeY.8XZYqiCHkuwrJUqfuKHakIvZO5GLgX3n0Fb1UjM7BSvVSD7i	9	1	Medis	MANAGER	aktif	\N	2026-04-15 08:29:33	2026-04-15 08:29:33
9	METRI JULIANTI, SE	20212767	metri.julianti	metri.julianti@rsazra.co.id	\N	$2y$12$jBaOs/odoOF3K9nY5MmdP.XAWjb4/NJHMatcVRTSaTp0jF8wxDPb6	9	43	Non Medis	MANAGER	aktif	\N	2026-04-15 08:29:33	2026-04-15 08:29:33
10	M. RANGGA ADITYA	20071107	m.rangga	m.rangga@rsazra.co.id	\N	$2y$12$UQRRAq.9z/oKzLjlutwdjukOH7HYIFhoi4fKcLm.0/cEFrSOgtA9e	9	1	Non Medis	DIREKTUR	aktif	\N	2026-04-15 08:29:33	2026-04-15 08:29:33
11	MUHAMAD MIFTAHUDIN, M. KOM	20242964	muhamad.miftahudin	muhamad.miftahudin@rsazra.co.id	\N	$2y$12$mbN4hgJ/YFr6S4qZVwc/legdKWWQIwBJuE8Qo63ECXqdkSJ7RWgJS	9	23	Non Medis	MANAGER	aktif	\N	2026-04-15 08:29:34	2026-04-15 08:29:34
12	RIA FAJARROHMI, SE	20242957	ria.fajarrohmi	ria.fajarrohmi@rsazra.co.id	\N	$2y$12$mbEl4pnAwDEE31gZO72nNuBTDRPVqiF0xBVxIf1/BZb9N84xYgtga	7	40	Non Medis	KEPALA	aktif	\N	2026-04-15 08:29:34	2026-04-15 08:29:34
13	RIYADI MAULANA, SH., MH., CLA., CCD	20111600	riyadi.maulana	riyadi.maulana@rsazra.co.id	\N	$2y$12$oc/bxLR1YzFY0AAKDT.YcegR9bsEMS4HM4OSuSi1tVJNa0WXa95pW	9	47	Non Medis	MANAGER	aktif	\N	2026-04-15 08:29:34	2026-04-15 08:29:34
14	SENI MAULIDA FITALOKA, S.KEP., NERS, M.KEP	19940189	seni.maulida	seni.maulida@rsazra.co.id	\N	$2y$12$EJPwrAxt/ICrm237Re2RiuLp/5RZ3dRcOz6Rs5FtrAq4OxI8PvBzi	9	50	Medis	MANAGER	aktif	\N	2026-04-15 08:29:34	2026-04-15 08:29:34
15	SITI KHOIRIAH	20020462	siti.khoiriah	siti.khoiriah@rsazra.co.id	\N	$2y$12$4OiQvNNJhDTRU4MoPMGWEeWFHCOwtVCoYAaQS05d92yIQn6QYA8kW	4	24	Non Medis	STAFF	aktif	\N	2026-04-15 08:29:34	2026-04-15 08:29:34
16	THORIQ FARIED ISHAQ, S.I. KOM	20253070	thoriq.faried	thoriq.faried@rsazra.co.id	\N	$2y$12$o2vvz2nSyJ7Ug/EjLVTypOeciOctJ4iRpi8elL/KDcE/xJfMsapGy	9	5	Non Medis	MANAGER	aktif	\N	2026-04-15 08:29:35	2026-04-15 08:29:35
17	TUMPAS BANGKIT PRAYUDA, SE	20253008	tumpas.bangkit	tumpas.bangkit@rsazra.co.id	\N	$2y$12$dfXooSkf4.4/YWHAQVjFC.LB8q72.H953EU1h2osQd7S/CNK8arGK	9	20	Non Medis	MANAGER	aktif	\N	2026-04-15 08:29:35	2026-04-15 08:29:35
18	VERONIKA RINI HANDAYANI, A. MD	20242988	veronika.rini	veronika.rini@rsazra.co.id	\N	$2y$12$6yYewEwI.mxO5.9KTXnMsumrkBfWwAr3PqQHlBKV0RFz2AJlkaZMO	4	24	Non Medis	STAFF	aktif	\N	2026-04-15 08:29:35	2026-04-15 08:29:35
19	ADE FIRMANSYAH	20121789	ade.firmansyah	ade.firmansyah@rsazra.co.id	\N	$2y$12$N94Cr0QQ/H4Mg2wCw6c9fuZZYWc2E/jqygtOPeyPKby9qo24UCIZ2	4	3	Medis	KHANZA RIRI ARISTIANI, S.Gz	aktif	\N	2026-04-15 08:29:35	2026-04-15 08:29:35
20	ADE IRPAN, SKM	20212831	ade.irpan	ade.irpan@rsazra.co.id	\N	$2y$12$KRQIN3zu2zPxaEbewedE.eLpE2okcgdcctNkJyRS6diOjcxDvihg2	5	4	Non Medis	THORIQ FARIED ISHAQ, S.I. KOM	aktif	\N	2026-04-15 08:29:36	2026-04-15 08:29:36
21	ADE SASMITA, SE	19950244	ade.sasmita	ade.sasmita@rsazra.co.id	\N	$2y$12$az0pX6BKGSQ4zcIVmMESBOpxLcCGQRiB06bW8PuMTYpRPJtgkX2ES	5	5	Non Medis	THORIQ FARIED ISHAQ, S.I. KOM	aktif	\N	2026-04-15 08:29:36	2026-04-15 08:29:36
22	AGUNG WIBOWO, S.Ars	20253041	agung.wibowo	agung.wibowo@rsazra.co.id	\N	$2y$12$8jicJz.wjhqWplS93sz3.uMKb6vcWXDjLsvQ2sFOogsq8Sj4/1e/O	4	6	Non Medis	THORIQ FARIED ISHAQ, S.I. KOM	aktif	\N	2026-04-15 08:29:36	2026-04-15 08:29:36
23	AGUS DARAJAT, Dr, Sp.A, M.Kes	20071152	agus.darajat	agus.darajat@rsazra.co.id	\N	$2y$12$Uj2k3jsk7ZMcU9O48gPYp.ATMh8dA508ugjWWUXryqRpBXGsSa7U6	10	7	Medis	RAHAYU AFIAH SURUR, DR	aktif	\N	2026-04-15 08:29:36	2026-04-15 08:29:36
24	AHMAD MAULANA APRYAWAN	20253038	ahmad.maulana	ahmad.maulana@rsazra.co.id	\N	$2y$12$GKR03n1mZONvdE3sM3K6xudzF5VXfkWvNV2Uxhny33KJTItQiZXO.	4	8	Medis	ERNA SUNARNI, AMAK	aktif	\N	2026-04-15 08:29:36	2026-04-15 08:29:36
26	AJI SAPRUDIN	20020506	aji.saprudin	aji.saprudin@rsazra.co.id	\N	$2y$12$HfW9NGYONX11lThxEq4gGejOhFISnE02KNL06ycxjnUpgIBXcqfyy	4	9	Non Medis	ADE SASMITA, SE	aktif	\N	2026-04-15 08:29:37	2026-04-15 08:29:37
27	ALFIAN KURNIAWAN	20253031	alfian.kurniawan	alfian.kurniawan@rsazra.co.id	\N	$2y$12$RaztN..mPu9ayboRc1km1OyDQwG3cPC8OOmSZQW.BSRN5FElIx2oq	5	6	Non Medis	THORIQ FARIED ISHAQ, S.I. KOM	aktif	\N	2026-04-15 08:29:37	2026-04-15 08:29:37
28	AMARTIWI, S.Kep., Ners	20212789	amartiwi	amartiwi@rsazra.co.id	\N	$2y$12$y8BbxxJaPnx4732c01RZKOpZIIKU0dqtg0fr3fCzOnwwr7wZt4/wu	6	16	Medis	YANTI HAPTIANI, S.Kep., Ners	aktif	\N	2026-04-15 08:29:37	2026-04-15 08:29:37
29	AMELIA SUSANTI, Amd.Kes	20242987	amelia.susanti	amelia.susanti@rsazra.co.id	\N	$2y$12$kExy554F85TXp928P8IpDuxuOQeHRYSK876QcvElFqi8Q7/hEAeri	4	7	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:29:37	2026-04-15 08:29:37
30	ANASTASIA DIAN PARLINA, S.Kep., Ners	20101508	anastasia.dian	anastasia.dian@rsazra.co.id	\N	$2y$12$BOj0vGNKW7c0OXn.j47GbezVSzSahl/MFx8gzTfaS.CzXEPmdYrti	5	17	Medis	SENI MAULIDA FITALOKA, S.Kep., Ns, M.Kep	aktif	\N	2026-04-15 08:29:38	2026-04-15 08:29:38
31	ANDIKA DWIPRASOJO, Amd.Kep	20212774	andika.dwiprasojo	andika.dwiprasojo@rsazra.co.id	\N	$2y$12$IR08CQaNP4lQbFYp2/OO8OR0GwjYaXhnTXMttdTKjnRDi/UVcsCB6	4	18	Medis	LESTARI RUMIYANI, S.Kep., Ns	aktif	\N	2026-04-15 08:29:38	2026-04-15 08:29:38
32	ANDI RENDRA HANDIKO, S.Tr	20212779	andi.rendra	andi.rendra@rsazra.co.id	\N	$2y$12$1hTF78s4.ZERZ3NZkTmeKeXZAL7D1/HXYcGknDbvKWqOL0RVKstiy	4	19	Medis	INTAN ANANDA UTAMI, Amd OT	aktif	\N	2026-04-15 08:29:38	2026-04-15 08:29:38
33	ANDRI IFTIYOKO, SH	20232906	andri.iftiyoko	andri.iftiyoko@rsazra.co.id	\N	$2y$12$Y6zF99mPSmKFkZzgqVkp8eAM8b8q9Ezw.LBvdfNRZvgCOWFW3lwde	5	20	Non Medis	TUMPAS BANGKIT PRAYUDA, SE	aktif	\N	2026-04-15 08:29:38	2026-04-15 08:29:38
34	ANGGITA SEVI, S.Farm	20202688	anggita.sevi	anggita.sevi@rsazra.co.id	\N	$2y$12$GmWyu9W0dVpn7thGmW3qg.3maAI7KMWBuoAyzNIrT7dueFNb09Y82	4	21	Medis	ELFA DIAN AGUSTINA, S.Farm, Apt	aktif	\N	2026-04-15 08:29:39	2026-04-15 08:29:39
25	AJENG PUSPA INDAH, S.Kep., Ners	20081261	ajeng.puspa	ajeng.puspa@rsazra.co.id	\N	$2y$12$GR1i0sI0.C/jSXrYy/bDR.5F69CPaBmxoKkq5t7Gv5OMeg8rpTc.i	2	2	Medis	DIENI ANANDA PUTRI, DR, MARS	aktif	\N	2026-04-15 08:29:37	2026-04-16 01:34:56
35	ANGGITA YULIANA PUTRI, S.Kep., Ners	20253095	anggita.yuliana	anggita.yuliana@rsazra.co.id	\N	$2y$12$AoYCrAaaYB66dgIdep71Je.UmsMj69oA/iTf6t.ZM5IvlF9yd5jem	4	16	Medis	YANTI HAPTIANI, S.Kep., Ners	aktif	\N	2026-04-15 08:29:39	2026-04-15 08:29:39
36	ANGGI WIDIASTUTI, S.Kep., Ners	20212797	anggi.widiastuti	anggi.widiastuti@rsazra.co.id	\N	$2y$12$kX54SRJXmZ.GKRpipQWVEOmH2E6WC3W.NCTaW5aSl.cgumZBSxwou	4	22	Medis	SAMSIAH, S.Kep., Ners	aktif	\N	2026-04-15 08:29:39	2026-04-15 08:29:39
37	ANGGUN ASTRIANNA APRIANTI, AMK	20202717	anggun.astrianna	anggun.astrianna@rsazra.co.id	\N	$2y$12$snPQlwxE7KU7le9aU3RnA.87lxpPg5vi76LpZBIytNuRMNC2sEJ8u	4	22	Medis	SAMSIAH, S.Kep., Ners	aktif	\N	2026-04-15 08:29:39	2026-04-15 08:29:39
38	ANISA OKTAVIANI, S.Kep., Ners	20242961	anisa.oktaviani	anisa.oktaviani@rsazra.co.id	\N	$2y$12$O5UNu755uIdp1EaOO8Rj4.hOh/j7zKrxn3RunjJXXlspuql0jnTG.	4	16	Medis	YANTI HAPTIANI, S.Kep., Ners	aktif	\N	2026-04-15 08:29:39	2026-04-15 08:29:39
39	ANNA SUHARDINING, S.Kep., Ns	19950208	anna.suhardining	anna.suhardining@rsazra.co.id	\N	$2y$12$zrUdudKTUBsFUi5FjvpnjO1vTeutApUzO8hRF2pWqQA6g6X5QKFnK	5	17	Medis	SENI MAULIDA FITALOKA, S.Kep., Ns, M.Kep	aktif	\N	2026-04-15 08:29:40	2026-04-15 08:29:40
40	ANSHAR FAISAL ISMI	20222874	anshar.faisal	anshar.faisal@rsazra.co.id	\N	$2y$12$02Yw5s7tn43yPCvI3nSb3.lyVSWwW0xXlyVVVyXITXW1ZBcWRnnaG	4	23	Non Medis	MUHAMAD MIFTAHUDIN, M.Kom	aktif	\N	2026-04-15 08:29:40	2026-04-15 08:29:40
41	ANTIKA PUTRI PRATAMI	20192664	antika.putri	antika.putri@rsazra.co.id	\N	$2y$12$.l2xU90hfeCOuC3yGsWiWOCGZIk3QG3z9L3BlOYrJvPD4QOB/sMv6	4	24	Non Medis	LILI MARLIANI, DR., MARS	aktif	\N	2026-04-15 08:29:40	2026-04-15 08:29:40
42	ARDELIA NURHAIDA, S.Farm	20222851	ardelia.nurhaida	ardelia.nurhaida@rsazra.co.id	\N	$2y$12$dPjI7U..UL9phNIVT0fuWuDaenlDonUBeW1TPG2J4phS97rPnYVsy	4	21	Medis	ELFA DIAN AGUSTINA, S.Farm, Apt	aktif	\N	2026-04-15 08:29:40	2026-04-15 08:29:40
43	ARI DAYOS TABAKWAN, S.Kep., Ners	20253039	ari.dayos	ari.dayos@rsazra.co.id	\N	$2y$12$L2gLRJR9EEM0KaTbjArtZeDQnXCMeuugLSNAxdOiowAbyNs613iYq	4	17	Medis	ANASTASIA DIAN PARLINA, S.Kep., Ners	aktif	\N	2026-04-15 08:29:41	2026-04-15 08:29:41
44	ARINI VIANSARI, Amd.Kep	20253004	arini.viansari	arini.viansari@rsazra.co.id	\N	$2y$12$MzH1APCdLA2RRu6y44//B.oMAUzr.GI3RBGFh.FSpxq/2slhM2wr2	5	25	Non Medis	IRMA RISMAYANTY, Dr, MM	aktif	\N	2026-04-15 08:29:41	2026-04-15 08:29:41
45	ARI NURYANI NAHAMPUAN, S.Kep., Ners	20253066	ari.nuryani	ari.nuryani@rsazra.co.id	\N	$2y$12$F3zCgcCamEh.cJJO.9QO.ujQRy2NXc4.a5Ev0DjJZpo.WVbwk.mX.	4	12	Medis	SRI YULIANI, S.Kep., Ners	aktif	\N	2026-04-15 08:29:41	2026-04-15 08:29:41
46	ARLIANA LESTARI, Amd.Kep	20253084	arliana.lestari	arliana.lestari@rsazra.co.id	\N	$2y$12$c7yd7JqOIeTLLLDJvi4o.emuhkAWOWK/CXGNR31XbQbqW.80IMD02	4	10	Medis	EKA SETIA WULANNINGSIH, S.Kep	aktif	\N	2026-04-15 08:29:41	2026-04-15 08:29:41
47	ASEP SARIF HIDAYATULLOH, S.Tr	20212784	asep.sarif	asep.sarif@rsazra.co.id	\N	$2y$12$lQRnP6N0x5EIvChVkPvgWO9PGu2/j0miT9JwpCON8PHSEkmGX/1d.	4	26	Medis	RAIMOND ANDROMEGA, DR., MPH	aktif	\N	2026-04-15 08:29:41	2026-04-15 08:29:41
48	AULIA MUNAJAT, S.Kep., Ners	20253077	aulia.munajat	aulia.munajat@rsazra.co.id	\N	$2y$12$zuORcDMvs9OBNOTOQFI55uQ5NDUazSk8edwYrPu3JAQ3ZKdKX5hdW	4	7	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:29:42	2026-04-15 08:29:42
49	AULIA PUSPITA SARI, S.Farm	20222857	aulia.puspita	aulia.puspita@rsazra.co.id	\N	$2y$12$cspchzLFr0wyUheaF85DL.ozASDECMOo5srMmvpaLq/Bg/auWzGdi	4	21	Medis	ELFA DIAN AGUSTINA, S.Farm, Apt	aktif	\N	2026-04-15 08:29:42	2026-04-15 08:29:42
50	AYU ANDIRA, Amd.Kep	20212787	ayu.andira	ayu.andira@rsazra.co.id	\N	$2y$12$dJGgBm6KU91wNtcNFRKYSuzFCIpmtHLd1IYkxfUewfpKDvqhPjm4S	4	13	Medis	SRI YULIANI, S.Kep., Ners	aktif	\N	2026-04-15 08:29:42	2026-04-15 08:29:42
51	AYU WULANDARI, AMK	20192549	ayu.wulandari	ayu.wulandari@rsazra.co.id	\N	$2y$12$475TpLsYDoorQTMngwNodu6Q5gAPheIdjvKlBVQSxnUdVPivln5Oe	4	7	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:29:42	2026-04-15 08:29:42
52	BAGYA HERMAWAN, BR.AMK	20071134	bagya.hermawan	bagya.hermawan@rsazra.co.id	\N	$2y$12$QyN4VKT4jazm4aB/pO6aAezVO1Qi6BCxvXXVNf66UcyQeAPo1SrL2	4	27	Medis	DIAN MAHDIANI, S.Kep., Ners	aktif	\N	2026-04-15 08:29:43	2026-04-15 08:29:43
53	BAMBANG PRIYADI	20030527	bambang.priyadi	bambang.priyadi@rsazra.co.id	\N	$2y$12$zz.NygU5lxnWSgIIUlgNY.K37mmZVg6NQyd8L0pVObBTmC4K4xuwi	4	28	Medis	RIA FAJARROHMI, SE	aktif	\N	2026-04-15 08:29:43	2026-04-15 08:29:43
54	BELADINNA ZALFA ZAHIRAH, S.Kep., Ners	20253028	beladinna.zalfa	beladinna.zalfa@rsazra.co.id	\N	$2y$12$XQYpL/NdPYGDmk89cOv5zuIuwl38hZr9JboR49wZG5DvbsD.MuaHO	4	7	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:29:43	2026-04-15 08:29:43
55	BENI YULIA, AMK	20061047	beni.yulia	beni.yulia@rsazra.co.id	\N	$2y$12$f/TeEuogyywtyNwrDYAfze5kX3Vi2YUgvKkH4qUu.rnd9eVfp6MG2	6	7	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:29:43	2026-04-15 08:29:43
56	BINAR SASONO, Dr. Sp.KFR	20242978	binar.sasono	binar.sasono@rsazra.co.id	\N	$2y$12$pIm0fjRvZS8Vjx/n8BW53uR6JD6541VHP25nx2P0u72II.UiszShC	10	29	Medis	GARCINIA SATIVA FIZRIA SETIADI, Dr, MKM	aktif	\N	2026-04-15 08:29:43	2026-04-15 08:29:43
57	BUDI HARTANTO	20061055	budi.hartanto	budi.hartanto@rsazra.co.id	\N	$2y$12$dOpx4DWifkOv0DmxDLI5Y.toxw5IxsQ0eYWLiVx8HXAkmr4q5TOhO	5	30	Non Medis	M MAHFUD ISRO, SE	aktif	\N	2026-04-15 08:29:44	2026-04-15 08:29:44
58	BUYUNG HERMAWAN	20020495	buyung.hermawan	buyung.hermawan@rsazra.co.id	\N	$2y$12$rX5BQuDtBdWxU2qiufxF8uk4TpcZSDtibBOzGqLv3sYwcy6iujxBi	4	31	Non Medis	ALFIAN KURNIAWAN	aktif	\N	2026-04-15 08:29:44	2026-04-15 08:29:44
59	CHANDRA BHAKTI PERWIRA, DR	20253049	chandra.bhakti	chandra.bhakti@rsazra.co.id	\N	$2y$12$SrtTjZtbjoChZ8VRjjGnuuPlrQ0ZMd8NXBPr4VUCSgvsf1E8glVfW	6	32	Medis	MUHAMMAD ARDYANSYAH PRATAMA, DR	aktif	\N	2026-04-15 08:29:44	2026-04-15 08:29:44
60	CHRISMA ADRYANA ALBANDJAR, Dr. Sp.An-KIC	20081257	chrisma.adryana	chrisma.adryana@rsazra.co.id	\N	$2y$12$ZnsrjTameIjIKqyW9ZfOXuiy0.Q0eC1RKWg4/CIqZlidYy776WA76	10	17	Medis	ANNA SUHARDINING, S.Kep., Ns	aktif	\N	2026-04-15 08:29:44	2026-04-15 08:29:44
61	CHUTTIA RAMADANTI, S.Kep., Ners	20253078	chuttia.ramadanti	chuttia.ramadanti@rsazra.co.id	\N	$2y$12$YgHYDDkflO5JCdA2n4aKJe7BeOYam1nAk9hC2ZML9aZhrwU3T/gHm	4	7	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:29:45	2026-04-15 08:29:45
62	DEA RATNA PUSPITASARI, S.Kep., Ners	20202734	dea.ratna	dea.ratna@rsazra.co.id	\N	$2y$12$QUCoA0o09UPlHwBDauT4Tekueq7vOwy6L0m3/b49QufAqDMNmzZzq	4	12	Medis	SRI YULIANI, S.Kep., Ners	aktif	\N	2026-04-15 08:29:45	2026-04-15 08:29:45
63	DELLA AYU PRATIWI, SE	20253069	della.ayu	della.ayu@rsazra.co.id	\N	$2y$12$7Vi8ZSNDAcN.T2mIsUf9meZ7HfnTO64NlQudLrzJ34qhTl46YLko.	4	30	Non Medis	BUDI HARTANTO	aktif	\N	2026-04-15 08:29:45	2026-04-15 08:29:45
64	DEVITA RIZKI AMELIANA, AMK	20091387	devita.rizki	devita.rizki@rsazra.co.id	\N	$2y$12$pZVy01keeuKb0dEsIKcl1OKcYEzfeL/iHiVtv3V/RYFG613djYouW	4	33	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:29:45	2026-04-15 08:29:45
65	DEWI KHANIA, Amd.Kes.Rad	20242929	dewi.khania	dewi.khania@rsazra.co.id	\N	$2y$12$heC7IxFBaBwyROCxsnYn6uQuyY0qWtc0.lhZSTCVWX/gKPKO3We9G	4	34	Medis	SEPTIAN NUGROHO, Amd.Rad	aktif	\N	2026-04-15 08:29:45	2026-04-15 08:29:45
66	DHESTY ANDHIANISA, Amd.Kep	20202706	dhesty.andhianisa	dhesty.andhianisa@rsazra.co.id	\N	$2y$12$pDws7pj.xcqR97fEiK597OJOb1fJfTNXRKVtkF8M9SEtSQH4kiyQW	4	18	Medis	LESTARI RUMIYANI, S.Kep., Ns	aktif	\N	2026-04-15 08:29:46	2026-04-15 08:29:46
67	DHIKA PRAMESTIKA, S.Kep., Ns	20050938	dhika.pramestika	dhika.pramestika@rsazra.co.id	\N	$2y$12$QhGD/gaJd9c2isupbmFV1uh53HiNzqBWK0ZjxdliNpjlBV9jRmfOK	5	20	Medis	TUMPAS BANGKIT PRAYUDA, SE	aktif	\N	2026-04-15 08:29:46	2026-04-15 08:29:46
68	DIAH AYU SEKARNINGTYAS, Amd.Ak	20222899	diah.ayu	diah.ayu@rsazra.co.id	\N	$2y$12$aKHwdiHPx70TUTCEL1nd6uKUGmawKmOFkhKlSR6cliZJ1YxkTWFq2	4	30	Non Medis	BUDI HARTANTO	aktif	\N	2026-04-15 08:29:46	2026-04-15 08:29:46
69	DIANA ROSITA, AMK	20172362	diana.rosita	diana.rosita@rsazra.co.id	\N	$2y$12$88qWKQu3elb9k51XFSO7huB6RLx/o.Rddan0K03gjxa4U0NVEvDI2	4	15	Medis	YANTI HAPTIANI, S.Kep., Ners	aktif	\N	2026-04-15 08:29:46	2026-04-15 08:29:46
70	DIAN MAHDIANI, S.Kep., Ners	20020550	dian.mahdiani	dian.mahdiani@rsazra.co.id	\N	$2y$12$KxS3ui.Tvi0UElGOGCjP2uqV4aj3SgXEMxM.JH87DhFTaYE5icAbO	5	27	Medis	SENI MAULIDA FITALOKA, S.Kep., Ns, M.Kep	aktif	\N	2026-04-15 08:29:47	2026-04-15 08:29:47
71	DIAN MATSYIWATI PUTRI SARI, S.Kep., Ners	20030642	dian.matsyiwati	dian.matsyiwati@rsazra.co.id	\N	$2y$12$gxedaVM3cxb/dI3/TGMRz.CQXO77wyZkX2hUHaUKGabgflqkomMDa	5	35	Medis	DIENI ANANDA PUTRI, DR, MARS	aktif	\N	2026-04-15 08:29:47	2026-04-15 08:29:47
72	DIAN NURUL HIKMAH, Amd.Gizi	20192595	dian.nurul	dian.nurul@rsazra.co.id	\N	$2y$12$FnZDvaecl6JDBHBtV1peR.0gmKYavmDrfGgsPiQkS7JZk1GBPKRXy	4	3	Medis	KHANZA RIRI ARISTIANI, S.Gz	aktif	\N	2026-04-15 08:29:47	2026-04-15 08:29:47
73	DIAN YUSTINANDA, DR	20101523	dian.yustinanda	dian.yustinanda@rsazra.co.id	\N	$2y$12$.I/J5GrnlaTvZeYeXXLB4.ojdnWHhxr.R7wjT2L3mKy.rkTHW/iF2	8	32	Medis	LILI MARLIANI, DR., MARS	aktif	\N	2026-04-15 08:29:47	2026-04-15 08:29:47
74	DIDI NARSIDI, S.Farm	20202703	didi.narsidi	didi.narsidi@rsazra.co.id	\N	$2y$12$0khQ1c0RJFNSuesOPZWKO.iMhdOnSdaj0txiV0XN46T0Srr97rzZa	4	21	Medis	ELFA DIAN AGUSTINA, S.Farm, Apt	aktif	\N	2026-04-15 08:29:47	2026-04-15 08:29:47
75	DINDA ANNISA FITRI, S.GZ	20222871	dinda.annisa	dinda.annisa@rsazra.co.id	\N	$2y$12$MK1U1/ZKxECZ7SiQRCHhVeQ34gTGS/eps2aRfztZ5XxQlVuWYVzwa	4	3	Medis	KHANZA RIRI ARISTIANI, S.Gz	aktif	\N	2026-04-15 08:29:48	2026-04-15 08:29:48
76	DINI HENDRAYANI, S.KEP., NERS	20192599	dini.hendrayani	dini.hendrayani@rsazra.co.id	\N	$2y$12$MbYV4r8EHkOxQQ328r473.mc/yxj0H7U1DbPezHarsoAltGdozIUC	4	7	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:29:48	2026-04-15 08:29:48
77	DWI ASTUTI, S.Psi	20253044	dwi.astuti	dwi.astuti@rsazra.co.id	\N	$2y$12$JR/.o.iVtURsGaGX0xvYA.0vYT4oqGEfBIo9UmtXQRiwJFgzUHYqy	5	36	Non Medis	INDRA THALIB, BSN., MM	aktif	\N	2026-04-15 08:29:48	2026-04-15 08:29:48
78	DWI IRMA SARI, S.Farm	20101481	dwi.irma	dwi.irma@rsazra.co.id	\N	$2y$12$Kt/OrBb4TiC1g8gGj3E.s.dCj5tTCFBQgJowa1j4bEXkWldMEwIpO	4	21	Medis	ELFA DIAN AGUSTINA, S.FARM, APT.	aktif	\N	2026-04-15 08:29:48	2026-04-15 08:29:48
79	DWI RETNO HANDAYANI, S.FARM, APT	20101532	dwi.retno	dwi.retno@rsazra.co.id	\N	$2y$12$WpwagaopeVlaIjBg/NtJ6.7LeLbfPwvXqHJjTX9pWZRQsLpE7L3qK	6	21	Medis	ELFA DIAN AGUSTINA, S.FARM, APT.	aktif	\N	2026-04-15 08:29:48	2026-04-15 08:29:48
80	DYAH ISTIATI, S.KEP., NERS	19960257	dyah.istiati	dyah.istiati@rsazra.co.id	\N	$2y$12$FuBwsXHMCz575phixGaQ5.3HDPB4yAqeLTKtOpi6VNt9xp3.sRrSe	4	22	Medis	SAMSIAH, S.KEP., NERS	aktif	\N	2026-04-15 08:29:49	2026-04-15 08:29:49
81	EKA KURNIASARI, S.S	20192592	eka.kurniasari	eka.kurniasari@rsazra.co.id	\N	$2y$12$l29tLMaCJZul3F5vKno9f.jYBc7HbJDnIsGg5p/ogg2SCc.fRrlRe	6	37	Non Medis	REGAWA PARRIKESIT, A.MD	aktif	\N	2026-04-15 08:29:49	2026-04-15 08:29:49
82	EKA SETIA WULANNINGSIH, S.Kep	20040661	eka.setia	eka.setia@rsazra.co.id	\N	$2y$12$Ikrc6y6jf/gHBxJefqv6Seq2x4ch.8nkYW9CEAAideASyyWNa7IWC	5	10	Medis	SENI MAULIDA FITALOKA, S.Kep, Ns, M.Kep	aktif	\N	2026-04-15 08:29:49	2026-04-15 08:29:49
83	ELFA DIAN AGUSTINA, S.FARM, APT	20253087	elfa.dian	elfa.dian@rsazra.co.id	\N	$2y$12$gcVwpTQuLCXVXsk0DzRK2e5piRZ81YvDqdFHZIC9.BizuYF5k9Usi	5	21	Medis	GARCINIA SATIVA FIZRIA SETIADI, Dr, MKM	aktif	\N	2026-04-15 08:29:49	2026-04-15 08:29:49
84	ELNI OKTAVIANI, DR	20253034	elni.oktaviani	elni.oktaviani@rsazra.co.id	\N	$2y$12$gffn6drxGfy6Yvlzrnw63e3XXQTk18V04lOhEh6aePHBhQU6N3VGu	4	32	Medis	MUHAMMAD ARDYANSYAH PRATAMA, DR	aktif	\N	2026-04-15 08:29:50	2026-04-15 08:29:50
85	ELSA SHYLVIA JUNIAR, AMD KEP	20192537	elsa.shylvia	elsa.shylvia@rsazra.co.id	\N	$2y$12$J6f1SsK9YfyONaRBiBEYGOmOM6.rAmlulrNKU3X5j8Hh5jZLZ9dRK	4	10	Medis	EKA SETIA WULANNINGSIH, S.Kep	aktif	\N	2026-04-15 08:29:50	2026-04-15 08:29:50
86	EMELIA SAPTYA MURTININGSIH, AMK	20030601	emelia.saptya	emelia.saptya@rsazra.co.id	\N	$2y$12$lw.Y6tQqTrqoC7S9igKWJeuCaRdkdCKVCQdiunCGJ2u6w6ekGFbr6	4	27	Medis	DIAN MAHDIANI, S.Kep., Ners	aktif	\N	2026-04-15 08:29:50	2026-04-15 08:29:50
87	EMILLIA HASANAH, S.Tr.Kes	20202678	emillia.hasanah	emillia.hasanah@rsazra.co.id	\N	$2y$12$FeSGNRvAMIsAHGNCnRIw6.fD9cuNVDPnDaDduhaXuNxD7bnWcXkw6	4	19	Medis	INTAN ANANDA UTAMI, Amd OT	aktif	\N	2026-04-15 08:29:50	2026-04-15 08:29:50
88	ENI SAKHNA, S.Kep., Ners	20061039	eni.sakhna	eni.sakhna@rsazra.co.id	\N	$2y$12$6zvL9ONekpghq6hHPNo4AeumaxYnr04OoTmr0z52Mtj8r7bzE2KGu	6	38	Medis	YANTI HAPTIANI, S.Kep., Ners	aktif	\N	2026-04-15 08:29:50	2026-04-15 08:29:50
89	ERNA MINAYATINA, AMK	20101424	erna.minayatina	erna.minayatina@rsazra.co.id	\N	$2y$12$zRaMANOo9ZKiuGGLbpAkNOWiqno.1gdoBSKT8xfXHZqtaYmI9L..y	4	22	Medis	SAMSIAH, S.KEP., NERS	aktif	\N	2026-04-15 08:29:51	2026-04-15 08:29:51
90	ERNA SUNARNI, AMAK	20040830	erna.sunarni	erna.sunarni@rsazra.co.id	\N	$2y$12$GLpXGruUqgnBk4naEs4B3OCGbz6KxU9VSXV9e4/XRF9FkkB80uIlO	5	8	Medis	GARCINIA SATIVA FIZRIA SETIADI, Dr, MKM	aktif	\N	2026-04-15 08:29:51	2026-04-15 08:29:51
91	ERVINA FITRIANI	20253027	ervina.fitriani	ervina.fitriani@rsazra.co.id	\N	$2y$12$6UsLYe2niedfGPIwXO3p1u.H1mTAcG1L/Ui886B4FmUkj1cgeYXH2	4	27	Medis	DIAN MAHDIANI, S.Kep., Ners	aktif	\N	2026-04-15 08:29:51	2026-04-15 08:29:51
92	ETI RAHMAWATI, AMD KEP	20202695	eti.rahmawati	eti.rahmawati@rsazra.co.id	\N	$2y$12$ykfuVHeJDeszZABhK2P8weIXF5psjJoLx3x0nU5cdawFvbxAqj1SG	4	7	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:29:51	2026-04-15 08:29:51
93	ETI ROHAETI, AMKG	20081221	eti.rohaeti	eti.rohaeti@rsazra.co.id	\N	$2y$12$GBw5w18KpRAGDdFvAG46XePUCRT1MsDOST8uHSyMgC.jnrj0eJFTK	4	7	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:29:52	2026-04-15 08:29:52
94	EVA OKTOVIANA, AMK	20242968	eva.oktoviana	eva.oktoviana@rsazra.co.id	\N	$2y$12$3VXT0/Q9hdUfIndsYvhrvO/t7rnoYXIoF2bEoG/SSgAcV4rL5SL.6	4	7	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:29:52	2026-04-15 08:29:52
95	EVI MINTARSIH, AMK	20020429	evi.mintarsih	evi.mintarsih@rsazra.co.id	\N	$2y$12$dUlATUO3pNuH4weKyPX4NO1fU3RVSY1DOcRSAI2ydfSQ78WMFq/BO	6	39	Medis	DIAN MAHDIANI, S.Kep., Ners	aktif	\N	2026-04-15 08:29:52	2026-04-15 08:29:52
96	EVI WULANDARI, A.MD	20192645	evi.wulandari	evi.wulandari@rsazra.co.id	\N	$2y$12$xXLkNwBcPkcIWl8rWHiPKeOo/I4wo9peMhFboR3eLfztQFHhAPpW.	4	30	Non Medis	BUDI HARTANTO	aktif	\N	2026-04-15 08:29:52	2026-04-15 08:29:52
97	FACHRI GINANJAR, A.MD	20192620	fachri.ginanjar	fachri.ginanjar@rsazra.co.id	\N	$2y$12$H952Ca.dtaac2YHQ1qiTlu7I6QnQZK.CJ.N37.Pn9.yZOhqCaCyIW	4	40	Non Medis	RIA FAJARROHMI, SE	aktif	\N	2026-04-15 08:29:52	2026-04-15 08:29:52
98	FACHRULREZA DJAEMI, AMD	20192623	fachrulreza.djaemi	fachrulreza.djaemi@rsazra.co.id	\N	$2y$12$ojF2/QPIlPBsqzyJF/X5Re6bR0QcwEzNgZrYMm4RLSK/Bc2/rvnB.	4	41	Medis	SOEPARNO, AMd.Perkes., S.MIK	aktif	\N	2026-04-15 08:29:53	2026-04-15 08:29:53
99	FADHILAH ULFAH, S.FARM., APT	20253007	fadhilah.ulfah	fadhilah.ulfah@rsazra.co.id	\N	$2y$12$puyfoskx5pDnncz8XnOTs.ZD3gcxhF85kLd9TE3RywGc0Tv6ZR6AS	4	21	Medis	ELFA DIAN AGUSTINA, S.FARM, APT.	aktif	\N	2026-04-15 08:29:53	2026-04-15 08:29:53
100	FAIZA DWI RAMADANIA, S.Tr.Kes	20253085	faiza.dwi	faiza.dwi@rsazra.co.id	\N	$2y$12$305zGO5i7ef1pGzYk4cyKur5tKt/nsjsEAQRNV1KLoeEMuMPhlR92	4	42	Medis	DIAN MAHDIANI, S.Kep., Ners	aktif	\N	2026-04-15 08:29:53	2026-04-15 08:29:53
101	FATMAWATI	19930083	fatmawati	fatmawati@rsazra.co.id	\N	$2y$12$60Kc/ZheKP9tub7Y8t5BkOKmxW.OMQEpe6xaL1KmC/rclbSEPnkr6	4	24	Non Medis	SITI KHOIRIAH	aktif	\N	2026-04-15 08:29:53	2026-04-15 08:29:53
102	FEBI ANGGRAINI, AMD	20222861	febi.anggraini	febi.anggraini@rsazra.co.id	\N	$2y$12$I8zeQ9qO8HwdW3UeaoCnueN8gmbls0TzmybzsxE4UIPmqEhwFuCpS	4	30	Non Medis	BUDI HARTANTO	aktif	\N	2026-04-15 08:29:54	2026-04-15 08:29:54
103	FERA ASRILIA, AMK	20040861	fera.asrilia	fera.asrilia@rsazra.co.id	\N	$2y$12$cSJRKXFFwM4raojq505Loe6j8qeiMtzQMZIp0FfR5tDYVYaJTvMUi	4	33	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:29:54	2026-04-15 08:29:54
104	FERDY DANIEL LATUPUTTY, S.Kep., Ners	20253060	ferdy.daniel	ferdy.daniel@rsazra.co.id	\N	$2y$12$eH0oYxe348kU2wjC2qFV3.h2zp5wagKUAYlsYod0eGYzMzWQgIOHC	4	10	Medis	EKA SETIA WULANNINGSIH, S.Kep	aktif	\N	2026-04-15 08:29:54	2026-04-15 08:29:54
105	FERI ANGRIAWAN, S.Tr	20192579	feri.angriawan	feri.angriawan@rsazra.co.id	\N	$2y$12$W6mHWsltZ9haM4aZjcsVau/..fMbPU5v22x5Tpx0hB36N4VhJpEjm	4	41	Medis	SOEPARNO, AMd.Perkes., S.MIK	aktif	\N	2026-04-15 08:29:54	2026-04-15 08:29:54
106	FIDA FIRDAUS PRIMIANDIKA	20232916	fida.firdaus	fida.firdaus@rsazra.co.id	\N	$2y$12$T7q1bfzNRpwpmZ0WbLLJmOORMJB1R4qh6J4X9wz5XnElx//voo6jq	4	34	Medis	SEPTIAN NUGROHO, AMD.Rad	aktif	\N	2026-04-15 08:29:54	2026-04-15 08:29:54
107	FINA FAUZIYAH, S.Kep., Ners	20212812	fina.fauziyah	fina.fauziyah@rsazra.co.id	\N	$2y$12$vVm8A7GqtJQ4B7dGvcFm7ueEXb80Gj2tzz39.OiZ7z/DabD/khusm	4	16	Medis	YANTI HAPTIANI, S.Kep., Ners	aktif	\N	2026-04-15 08:29:55	2026-04-15 08:29:55
108	FIRMAN HAFITHUDIN SYAH, A.MD	20192646	firman.hafithudin	firman.hafithudin@rsazra.co.id	\N	$2y$12$DtOTRfVUsVhA15xKYHvStOkx3811UsRVm7m2pcXaUnw1RAGnTpFKW	6	43	Non Medis	HADI KURNIAWAN, S.M	aktif	\N	2026-04-15 08:29:55	2026-04-15 08:29:55
109	FITRI WIJAYANTI, AM.Keb	20081218	fitri.wijayanti	fitri.wijayanti@rsazra.co.id	\N	$2y$12$GdkRbdJYEEGMD8x4YOuFxuT.S5qMXttkxNC6f/uTuJf2L14ud4TRO	4	44	Medis	IRENE SRI SUMARNI, AM.Keb	aktif	\N	2026-04-15 08:29:55	2026-04-15 08:29:55
110	FITRIYANI MEGAWATI, AMD Perkes	20141999	fitriyani.megawati	fitriyani.megawati@rsazra.co.id	\N	$2y$12$Owlj7pr.EHOFZCGZqo/pFeNDzJhXn6IdcF5T1zDSH5rAZRltESacO	4	41	Medis	SOEPARNO, AMd.Perkes., S.MIK	aktif	\N	2026-04-15 08:29:55	2026-04-15 08:29:55
111	GARSIANA SRI HASANAH, S.FARM., APT	20131947	garsiana.sri	garsiana.sri@rsazra.co.id	\N	$2y$12$v69TkNZIofHSloZZxu58CetzfsQkoLw0oTSDkwtwQPBj1zqKJkTX6	6	21	Medis	ELFA DIAN AGUSTINA, S.FARM, APT.	aktif	\N	2026-04-15 08:29:56	2026-04-15 08:29:56
112	GHANIS GUSVIRANTY BAYU, AMD.Keb	20252999	ghanis.gusviranty	ghanis.gusviranty@rsazra.co.id	\N	$2y$12$0iNhsC4k8unYRa5/SJMMY.aA0muGpsl.gRMVq.HIqjNmWt9HW8vly	4	20	Non Medis	DHIKA PRAMESTIKA, S.Kep., Ns	aktif	\N	2026-04-15 08:29:56	2026-04-15 08:29:56
113	GRACIA, S.Kep., Ners	20253043	gracia	gracia@rsazra.co.id	\N	$2y$12$sECt.UIwbV5DcWYcOwc96ukSXB90JN0VDU3sJES0CKyonwhzL6mPu	4	38	Medis	YANTI HAPTIANI, S.Kep., Ners	aktif	\N	2026-04-15 08:29:56	2026-04-15 08:29:56
114	HADI KURNIAWAN, S.M	20020466	hadi.kurniawan	hadi.kurniawan@rsazra.co.id	\N	$2y$12$/j9wZWTdg4hyR29Xz3BZUOlxtZeunZgzGjpEgF5CxC.wkjf/F4E6u	5	43	Non Medis	M MAHFUD ISRO, S.E	aktif	\N	2026-04-15 08:29:56	2026-04-15 08:29:56
115	HADIN AZIZ ABDURROHMAN, S.Tr	20202748	hadin.aziz	hadin.aziz@rsazra.co.id	\N	$2y$12$RTvAJy3wfzq77eirHqr/JeSX1q3v4.LlhrA64MTUPbXa2INWV5hoy	4	41	Medis	SOEPARNO, AMd.Perkes., S.MIK	aktif	\N	2026-04-15 08:29:56	2026-04-15 08:29:56
116	HALIMATUSSA DIYAH WIDIASTI, S.Tr.Kes	20253089	halimatussa.diyah	halimatussa.diyah@rsazra.co.id	\N	$2y$12$v4UZ2exZkNYDyD9yKtOxyO3dowDGw87wZwsipY6gXn1uLBCBfo1u.	4	19	Medis	INTAN ANANDA UTAMI, Amd OT	aktif	\N	2026-04-15 08:29:57	2026-04-15 08:29:57
117	HANIFA AZZAHRA, S.FARM., APT	20253014	hanifa.azzahra	hanifa.azzahra@rsazra.co.id	\N	$2y$12$XpQPEhNEDiMQwJAElEK2TOf7v5S883F8QJzrg9EV6pe2uaL0NxfAG	4	21	Medis	ELFA DIAN AGUSTINA, S.FARM, APT.	aktif	\N	2026-04-15 08:29:57	2026-04-15 08:29:57
118	HANIFAH WINIARTI, AMK	20101421	hanifah.winiarti	hanifah.winiarti@rsazra.co.id	\N	$2y$12$OMnMgC3s3UqmtV82uHbhlO1krrzMwpyxi.m6rOzgaKi.XpS2cWUim	4	17	Medis	ANASTASIA DIAN PARLINA, S.Kep., Ners	aktif	\N	2026-04-15 08:29:57	2026-04-15 08:29:57
119	HERI SILVIA, AMK	20020431	heri.silvia	heri.silvia@rsazra.co.id	\N	$2y$12$KU8hxacwFHnAg2WJkSh8eeCa5rlL/PSf4BDtpwdJ1YSWqqO54wAku	4	18	Medis	LESTARI RUMIYANI, S.KEP., NS	aktif	\N	2026-04-15 08:29:57	2026-04-15 08:29:57
120	HILDA NEVIKAYATI, AMK	20061012	hilda.nevikayati	hilda.nevikayati@rsazra.co.id	\N	$2y$12$OX6jf3JE5CSOvqe1hQzGqOn.7X8Hsh.07o/fxdbY401XPI1DLo2uq	4	18	Medis	LESTARI RUMIYANI, S.KEP., NS	aktif	\N	2026-04-15 08:29:57	2026-04-15 08:29:57
121	HUSNUL FUADAH, S. KEP., NERS	20242935	husnul.fuadah	husnul.fuadah@rsazra.co.id	\N	$2y$12$PZtyYQwcFAsbqyuLduJvgOyQjQH7phJShH.GDSA6i1TEsmuFwZKvK	4	16	Medis	YANTI HAPTIANI, S.KEP., NERS	aktif	\N	2026-04-15 08:29:58	2026-04-15 08:29:58
122	IDA ROSIDA, S. KEP., NERS	20242944	ida.rosida	ida.rosida@rsazra.co.id	\N	$2y$12$Oig2EEPQrCzOBG4mYe35OunPozyOSdiWTCdfKTnXB8uv4bg/4DMde	4	38	Medis	YANTI HAPTIANI, S.KEP., NERS	aktif	\N	2026-04-15 08:29:58	2026-04-15 08:29:58
123	I DEWA AYU YUNITA PERMATA SARI, AMD KEP	20212793	i.dewa	i.dewa@rsazra.co.id	\N	$2y$12$yQ6u6oWoWquuh7T6O/fCN.U9hL8WLEPxjSZnQHdoKSYU3tf/QAgz2	4	15	Medis	YANTI HAPTIANI, S.KEP., NERS	aktif	\N	2026-04-15 08:29:58	2026-04-15 08:29:58
124	IHAH SOLIHAH, S.TR.KEB	20182466	ihah.solihah	ihah.solihah@rsazra.co.id	\N	$2y$12$0Q8kOV5LeZAt8FSlXfmm9umiAEdUbUT144WRn7NfmjyqWXWubJxoK	4	7	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:29:58	2026-04-15 08:29:58
125	IKA PURNAMASARI, AMK	20071157	ika.purnamasari	ika.purnamasari@rsazra.co.id	\N	$2y$12$ehM54PFIlOy.Cvipr7vroeEobae.pLDYrMByMcSL1AfOJx1DAHULm	6	11	Medis	EKA SETIA WULANNINGSIH, S.KEP	aktif	\N	2026-04-15 08:29:59	2026-04-15 08:29:59
126	IMELDA GRACE CAROLINA H, DR	20101510	imelda.grace	imelda.grace@rsazra.co.id	\N	$2y$12$Xvr1xYB9qJ3zVPkPyTsL1e0cDqKNzI/PTiaGi/w4TllQcdcZfcbTK	4	32	Medis	MUHAMMAD ARDYANSYAH PRATAMA, DR	aktif	\N	2026-04-15 08:29:59	2026-04-15 08:29:59
127	INDAH NURHASANAH, SE	20192563	indah.nurhasanah	indah.nurhasanah@rsazra.co.id	\N	$2y$12$vyn3KpWDgdmiP/qfttK.MeXMusb5X6MHC0S05jhRmrS/6tDVOm4xy	6	37	Non Medis	REGAWA PARRIKESIT., A. MD	aktif	\N	2026-04-15 08:29:59	2026-04-15 08:29:59
128	INDAH TRIYANI	20202687	indah.triyani	indah.triyani@rsazra.co.id	\N	$2y$12$oeG7pmqslJ0dC2rpHtDXc.3ki4UP9YE221yUkhPks1dpalD6U20yO	5	28	Medis	RIA FAJARROHMI, SE	aktif	\N	2026-04-15 08:29:59	2026-04-15 08:29:59
129	INDI INDRIYANI, AMD KEP	20172271	indi.indriyani	indi.indriyani@rsazra.co.id	\N	$2y$12$5dCyabgOBtepDzJgjQF5nOesPCZ6YmLcjRPqTjvUbIlkxF5.eqeJ2	4	22	Medis	SAMSIAH, S.KEP., NERS	aktif	\N	2026-04-15 08:29:59	2026-04-15 08:29:59
130	INDIVI AHMAD, S.TR.FT	20253097	indivi.ahmad	indivi.ahmad@rsazra.co.id	\N	$2y$12$anCPAj3JhL9rVrle0dtyg.gEkadXyCxDQUgYI.mL.kSEMTOOhkmhG	4	29	Medis	INTAN ANANDA UTAMI, AMD OT	aktif	\N	2026-04-15 08:30:00	2026-04-15 08:30:00
131	INDRI NURAIDA HAMDIAH, S.KEP., NERS	20212842	indri.nuraida	indri.nuraida@rsazra.co.id	\N	$2y$12$YDFmBqWXoqnA782jB826N./ribA.Ku0HIZ8mywR.ftRgH7xaf.9GK	4	7	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:30:00	2026-04-15 08:30:00
133	INTAN INDRI ARDIYANTI., M.TR.TGM	20253025	intan.indri	intan.indri@rsazra.co.id	\N	$2y$12$9twk1Znd9tvMFOgwQdxBCuCyPWO6vGcKpnI3AQY/BfLJ8qdyrDLNG	4	7	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:30:00	2026-04-15 08:30:00
134	IRAWATI KUMALA, S.KEP., NERS	20192598	irawati.kumala	irawati.kumala@rsazra.co.id	\N	$2y$12$MObEnzp2TB7.IyGjXgKObet25old3epb5owaU8e0hHhfj6dfWh.YW	4	7	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:30:01	2026-04-15 08:30:01
135	IRENE SRI SUMARNI, AM.KEB	19990369	irene.sri	irene.sri@rsazra.co.id	\N	$2y$12$Zqf2BGCO32JdbDhvj4dljOhtgH0G03d4UGUGaRKBy7q1XnwiJ.oR6	5	44	Medis	SENI MAULIDA FITALOKA, S.KEP., NS, M.KEP	aktif	\N	2026-04-15 08:30:01	2026-04-15 08:30:01
136	IWAN SETIAWAN	19930060	iwan.setiawan	iwan.setiawan@rsazra.co.id	\N	$2y$12$/sHUftc.CSEnKx7derJ9xeGXXYXaqSFUopCjcjiLdqnZ4u47UCpQ.	4	39	Medis	EVI MINTARSIH, AMK	aktif	\N	2026-04-15 08:30:01	2026-04-15 08:30:01
137	JAMALUDIN., A. MD	20192647	jamaludin	jamaludin@rsazra.co.id	\N	$2y$12$6uTMErLcI3pnACHWLVJzi.Ns/nvkPDolOPGxuvFmLIrB0XixwJX8K	4	43	Non Medis	HADI KURNIAWAN, S.M	aktif	\N	2026-04-15 08:30:01	2026-04-15 08:30:01
138	KARTA WARDANA, SST.FT	20172359	karta.wardana	karta.wardana@rsazra.co.id	\N	$2y$12$xbcliCgE4wwLpLEScux42.tjNIBdbCqJUwF4gBGrhbvoD3SMP3ESa	4	19	Medis	INTAN ANANDA UTAMI, AMD OT	aktif	\N	2026-04-15 08:30:01	2026-04-15 08:30:01
139	KARYANI	19950243	karyani	karyani@rsazra.co.id	\N	$2y$12$ceTlAiOukskKr6uUvu/wCOILzvTdrEbdnevBhlfitnMGCYiGFiJZy	4	8	Medis	ERNA SUNARNI, AMAK	aktif	\N	2026-04-15 08:30:02	2026-04-15 08:30:02
140	KEISA KAMILA, A.MD.KES	20253096	keisa.kamila	keisa.kamila@rsazra.co.id	\N	$2y$12$igyQm7kRiIEQPD6V.Vw9Y.4LUYj4WM09UvQ/HCzb4FnfQAY/GaP2a	4	29	Medis	INTAN ANANDA UTAMI, Amd OT	aktif	\N	2026-04-15 08:30:02	2026-04-15 08:30:02
141	KHAERUL ANWAR RUDDIN	20121745	khaerul.anwar	khaerul.anwar@rsazra.co.id	\N	$2y$12$Q5KpFShBfaDfHo1X3aafq.4ly2dixjVJ5RNnFG4dEUH5/x.pDqerO	4	3	Medis	KHANZA RIRI ARISTIANI, S.Gz	aktif	\N	2026-04-15 08:30:02	2026-04-15 08:30:02
142	KHAIRUN NISA NURAKHYATI, S.Kep., Ns, MARS	19960217	khairun.nisa	khairun.nisa@rsazra.co.id	\N	$2y$12$/m8vKG2Tp6445XptIo5rVOMNt6wOqaLv/haYaFWmUfgp5OQJiU8/W	5	36	Non Medis	INDRA THALIB, BSN., MM	aktif	\N	2026-04-15 08:30:02	2026-04-15 08:30:02
143	KHANZA RIRI ARISTIANI, S.Gz	20192540	khanza.riri	khanza.riri@rsazra.co.id	\N	$2y$12$teWfJDP5s6oHX15wmVRSoeALQvlpCC6AursVAkMeDLNbdncEzSefu	5	3	Medis	GARCINIA SATIVA FIZRIA SETIADI, Dr, MKM	aktif	\N	2026-04-15 08:30:02	2026-04-15 08:30:02
144	KRISTIANI, AMK	20040854	kristiani	kristiani@rsazra.co.id	\N	$2y$12$.JeXKnvpxWtOXOtgHj81N.uz91rLb7BX01ed0Flt9Cphsy0Wg59gO	4	33	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:30:03	2026-04-15 08:30:03
145	KUSWADI	19930156	kuswadi	kuswadi@rsazra.co.id	\N	$2y$12$raYeg7DVS.U.1Z0LN0.EJuCMXDZVNMfi1oUeX373iWGyxO1.VHCDi	4	39	Medis	EVI MINTARSIH, AMK	aktif	\N	2026-04-15 08:30:03	2026-04-15 08:30:03
146	LAELAH MEITARNENGSIH, AMK	20071151	laelah.meitarnengsih	laelah.meitarnengsih@rsazra.co.id	\N	$2y$12$A4qnW2T0W.nh9EMPEUWereQmqHjqofBHd/aOY7jiEkkH7/zO1rULy	4	18	Medis	LESTARI RUMIYANI, S.Kep., Ns	aktif	\N	2026-04-15 08:30:03	2026-04-15 08:30:03
147	LALA FADLIATUS SYAHADA, A.MD	20192617	lala.fadliatus	lala.fadliatus@rsazra.co.id	\N	$2y$12$eG3hMn2EVeAZEIZV36XotenQD5YOJJfG9XToTQ5/n8DZpyDeEfmKO	4	30	Non Medis	BUDI HARTANTO	aktif	\N	2026-04-15 08:30:03	2026-04-15 08:30:03
148	LANI RAHAYU, S.Kep., Ns	20091398	lani.rahayu	lani.rahayu@rsazra.co.id	\N	$2y$12$O9bP9ns1R6y1oKUpVg6kP.nkUbsW34jlzAHIqxWaKKngX2Bnw78ku	4	12	Medis	SRI YULIANI, S.Kep., Ners	aktif	\N	2026-04-15 08:30:04	2026-04-15 08:30:04
149	LAYUNG SARI, S.Kep., Ners	20050986	layung.sari	layung.sari@rsazra.co.id	\N	$2y$12$8Q2dxxUkGOtplxKM/DDl4e12pu9L5Px6/mG87Bm3M3.5Tzl95iJJ6	4	22	Medis	SAMSIAH, S.Kep., Ners	aktif	\N	2026-04-15 08:30:04	2026-04-15 08:30:04
150	LESTARI RUMIYANI, S.Kep., Ns	20020426	lestari.rumiyani	lestari.rumiyani@rsazra.co.id	\N	$2y$12$my1LYSL/Xx01cC2/B7myS.GgS96uw.AgLHQYLnrGFjmXJbAap9YwS	5	18	Medis	SENI MAULIDA FITALOKA, S.Kep., Ns, M.Kep	aktif	\N	2026-04-15 08:30:04	2026-04-15 08:30:04
151	LILIS, Amd Kep	20212791	lilis	lilis@rsazra.co.id	\N	$2y$12$yOUD81XIG9rtId3s2Px/QuoDRpnUpg2R3JoDeNtjUFIRB.GNAHT6O	4	7	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:30:04	2026-04-15 08:30:04
152	LILIS MELDIANI, AMD.AK	20242969	lilis.meldiani	lilis.meldiani@rsazra.co.id	\N	$2y$12$t205/iqB1BOvHKPl4mH/oeHxf2zrL8f988EKgtCKEpG6w4juCpr.2	4	8	Medis	ERNA SUNARNI, AMAK	aktif	\N	2026-04-15 08:30:05	2026-04-15 08:30:05
153	LINDA ANNISA LISDIANI, AMD KEP	20182440	linda.annisa	linda.annisa@rsazra.co.id	\N	$2y$12$m/VxQAjO8eDSA4hMXPtjZe1F/VwqfRs9i48mSdGkSorYUy.Mqg8Vy	4	7	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:30:05	2026-04-15 08:30:05
154	LIRA SUCI RAMADHAN	20253047	lira.suci	lira.suci@rsazra.co.id	\N	$2y$12$epaupfh/dxc6W.3tfxvYD.5G7zzsgEI6X/9Nw.3aRYtJ6GBHOfBiq	4	20	Non Medis	ANDRI IFTIYOKO, SH	aktif	\N	2026-04-15 08:30:05	2026-04-15 08:30:05
155	LISNA WULAN OKTAVIA ARTANTI, S.Kep., Ners	20182442	lisna.wulan	lisna.wulan@rsazra.co.id	\N	$2y$12$sIvPN4.j0LyGv7RrSHWhy.DsoVYYSJPOTN6xzK81hCptLbrCCA/Y2	4	38	Medis	YANTI HAPTIANI, S.Kep., Ners	aktif	\N	2026-04-15 08:30:05	2026-04-15 08:30:05
156	LUFTI TRI WAHYUNI, AMK	20202733	lufti.tri	lufti.tri@rsazra.co.id	\N	$2y$12$3Oyabr79IUGAQFpmKrPnXuA.XKABBV2hjJRdbacmrEx6qKyJC9GBe	4	15	Medis	YANTI HAPTIANI, S.Kep., Ners	aktif	\N	2026-04-15 08:30:05	2026-04-15 08:30:05
157	LUKMAN HAKIM, S.Farm	20222892	lukman.hakim	lukman.hakim@rsazra.co.id	\N	$2y$12$mbW3KLNbg5j3.b.RUlbYZ.W6Bvpi6nPKceP/kLeFwbIQK9wFaikC6	4	21	Medis	ELFA DIAN AGUSTINA, S.FARM, APT.	aktif	\N	2026-04-15 08:30:06	2026-04-15 08:30:06
158	LUTFIAH NUR SHADRINA	20253026	lutfiah.nur	lutfiah.nur@rsazra.co.id	\N	$2y$12$ipwzYMTIM.aZaLiHFeRwf.1HAhfRwr5JiAgmUBTtIUhfJAC8zonBu	4	7	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:30:06	2026-04-15 08:30:06
159	MAMAN TASMAN	20020486	maman.tasman	maman.tasman@rsazra.co.id	\N	$2y$12$MYIAfJzjoMlToB5t7fnW5eDePnSJc05NNfQERbVcKaK6KM88DqjvW	4	43	Non Medis	HADI KURNIAWAN, S.M	aktif	\N	2026-04-15 08:30:06	2026-04-15 08:30:06
160	MAMAT	20040833	mamat	mamat@rsazra.co.id	\N	$2y$12$WM5ZTR6v5izw3e0XLbCQ/OK5s0d/8UP/Ot13nXo8BgBLISWmwme/O	4	9	Non Medis	ADE SASMITA, SE	aktif	\N	2026-04-15 08:30:06	2026-04-15 08:30:06
161	MARIA ULFA, AMD KEP	20182500	maria.ulfa	maria.ulfa@rsazra.co.id	\N	$2y$12$1q4JeU5anwqIRBs2HyTYAeeJEeFK4ff1vdo.skSY6wMsLM3FBGAcu	4	15	Medis	YANTI HAPTIANI, S.Kep., Ners	aktif	\N	2026-04-15 08:30:07	2026-04-15 08:30:07
162	MARIA ULFA, AMD KEP	20263099	maria.ulfa1	maria.ulfa1@rsazra.co.id	\N	$2y$12$XuUlWQbKZAGORalE.a5lyOCR89V7/3NmKE3k.8ED8iHyHdinr5eV2	4	15	Medis	YANTI HAPTIANI, S.Kep., Ners	aktif	\N	2026-04-15 08:30:07	2026-04-15 08:30:07
163	MARISA LENI PUTRI, AMK	20182502	marisa.leni	marisa.leni@rsazra.co.id	\N	$2y$12$get2PrhiwNP0JvBdY5NV3uZD7EkEOqvw2LZiGe9O0bj2W2wRuZPHS	4	27	Medis	DIAN MAHDIANI, S.Kep., Ners	aktif	\N	2026-04-15 08:30:07	2026-04-15 08:30:07
164	MARNI MUNAWAROH, AMD KEP	20212766	marni.munawaroh	marni.munawaroh@rsazra.co.id	\N	$2y$12$E.XqKJiEI5qfysQtuGPKPuLLg7RV4Y5nDfUp0etf52c9SXb3Hojbu	4	7	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:30:07	2026-04-15 08:30:07
165	MARTA DWI CAHYA LESTARI, AMD.Kes (Rad)	20253010	marta.dwi	marta.dwi@rsazra.co.id	\N	$2y$12$hFoJpudmd.NX9kvyvWqCau2fYTqpxWrMbEViVOP/r31rEgXvruNDO	4	34	Medis	SEPTIAN NUGROHO, AMD.Rad	aktif	\N	2026-04-15 08:30:07	2026-04-15 08:30:07
166	MEILIA RATNAPURI, AMD KEP	20202719	meilia.ratnapuri	meilia.ratnapuri@rsazra.co.id	\N	$2y$12$B0uJsVCnqmZ07.Eq5eqs0.he887TIfY0trel4u2fPGnX73Z/b.a6K	4	15	Medis	YANTI HAPTIANI, S.Kep., Ners	aktif	\N	2026-04-15 08:30:08	2026-04-15 08:30:08
167	MILA RAHMAWATI, A.MD.RMIK	20253065	mila.rahmawati	mila.rahmawati@rsazra.co.id	\N	$2y$12$AMMAnNaDaGxg62epAmItJ.KCMMx/HgpAgfeELK.FGb4RdK1vAgsuW	4	41	Medis	SOEPARNO, AMd.Perkes., S.MIK	aktif	\N	2026-04-15 08:30:08	2026-04-15 08:30:08
168	MIRANTI, S.Kep., Ners	20253094	miranti	miranti@rsazra.co.id	\N	$2y$12$df070tczaZYpJaIBXArwfOcE.B3gES/7uvpwACYJiwS6WaF2kLqIC	4	10	Medis	EKA SETIA WULANNINGSIH, S.Kep	aktif	\N	2026-04-15 08:30:08	2026-04-15 08:30:08
169	M MAHFUD ISRO, S.E	20020458	m.mahfud	m.mahfud@rsazra.co.id	\N	$2y$12$vDHzrWnmA9XAJ2DBCwTGLu2WjtKTvg350RliLON3UIuYWMmJwlLsK	7	43	Non Medis	METRI JULIANTI, SE	aktif	\N	2026-04-15 08:30:08	2026-04-15 08:30:08
170	MOCHAMAD RYAN DWI PRATAMA PUTRA, SE	20212825	mochamad.ryan	mochamad.ryan@rsazra.co.id	\N	$2y$12$qGbK9hxDeODY1z7eoj4sauwrLseyGCUuxbNAqujlaNbam8s42PmQG	4	30	Non Medis	BUDI HARTANTO	aktif	\N	2026-04-15 08:30:09	2026-04-15 08:30:09
171	MOCH IRFAN FIRDAUS, A.MD	20061042	moch.irfan	moch.irfan@rsazra.co.id	\N	$2y$12$uplWTXgtEXMbWWA38wkGSekQfrQnTdX.OvHiI5JasLzeYNBCZqbuC	4	26	Non Medis	RAIMOND ANDROMEGA, DR., MPH	aktif	\N	2026-04-15 08:30:09	2026-04-15 08:30:09
172	MOHAMAD DANDI KURNIAWAN, S.Tr.Kes	20020422	mohamad.dandi	mohamad.dandi@rsazra.co.id	\N	$2y$12$pfIzu6X4vO0.IInnaqZvxe.yKoQ4KNeRAc0Mh9bV3BiDsMxR6hHP2	4	29	Medis	INTAN ANANDA UTAMI, Amd OT	aktif	\N	2026-04-15 08:30:09	2026-04-15 08:30:09
173	MOHAMMAD PATI SIDIK	20020488	mohammad.pati	mohammad.pati@rsazra.co.id	\N	$2y$12$0bkqeIygBpWh0BXLG0QfUeWaPpkPJ1Y94.jInY8UaUgVaU2yqIQJK	4	36	Non Medis	DWI ASTUTI, S.Psi	aktif	\N	2026-04-15 08:30:09	2026-04-15 08:30:09
174	MONE RIZKI DESANDRY	20253024	mone.rizki	mone.rizki@rsazra.co.id	\N	$2y$12$kmnzUX3E8aKdrVuV1VF79eB30kpR0S7TcltGyzOX7lmxJkvS0nD1W	4	20	Non Medis	ANDRI IFTIYOKO, SH	aktif	\N	2026-04-15 08:30:09	2026-04-15 08:30:09
175	MUHAMAD OKY PATI IDRIS	20030525	muhamad.oky	muhamad.oky@rsazra.co.id	\N	$2y$12$FGlYBCaDWBln2pfdVAwtm.qn4ZgZaQok5YBm2hDxmvU7/i2OffBry	4	43	Medis	M MAHFUD ISRO, S.E	aktif	\N	2026-04-15 08:30:10	2026-04-15 08:30:10
176	MUHAMMAD ARDYANSYAH PRATAMA, DR	20172398	muhammad.ardyansyah	muhammad.ardyansyah@rsazra.co.id	\N	$2y$12$sat4VjqSMKYZPg6OPVnKFeMrblrcsv7B0HmtKLyDkSCnrTnEDHABW	8	32	Medis	LILI MARLIANI, DR., MARS	aktif	\N	2026-04-15 08:30:10	2026-04-15 08:30:10
177	MUHAMMAD FARHAN SETIAWAN, S.Tr.Kes	20253023	muhammad.farhan	muhammad.farhan@rsazra.co.id	\N	$2y$12$sTw.9vjJ85BM.oR6jsNi8u9n9mwEbfgvqjrnRoUIYPSUcTCZr4GeO	4	42	Medis	DIAN MAHDIANI, S.Kep., Ners	aktif	\N	2026-04-15 08:30:10	2026-04-15 08:30:10
178	MUHAMMAD FHADLUL SYAHRI, A.MD.Kes	20242963	muhammad.fhadlul	muhammad.fhadlul@rsazra.co.id	\N	$2y$12$pBHRkEJIbuvz/FgIw.dvyedVLug7K8cH0QiJgtTkdkLaw.Ty4m6/S	4	29	Medis	INTAN ANANDA UTAMI, Amd OT	aktif	\N	2026-04-15 08:30:10	2026-04-15 08:30:10
179	MUHAMMAD HUSNUL KHULUQ, S.Ak	20202676	muhammad.husnul	muhammad.husnul@rsazra.co.id	\N	$2y$12$Nkl5WE8s6ee75iw5kJTZvu88yckqh71PleI0LIECX2G2WJlKiagn6	4	30	Non Medis	BUDI HARTANTO	aktif	\N	2026-04-15 08:30:11	2026-04-15 08:30:11
180	MUHAMMAD LAZUARDI E, AMK	20172382	muhammad.lazuardi	muhammad.lazuardi@rsazra.co.id	\N	$2y$12$o6cl8ucgNLS764WW98QSq.L43QVoYCNuVGPUW1ZgoceVChnLTrAsy	4	27	Medis	DIAN MAHDIANI, S.Kep., Ners	aktif	\N	2026-04-15 08:30:11	2026-04-15 08:30:11
181	MUIZAR	20101450	muizar	muizar@rsazra.co.id	\N	$2y$12$53Ef0Cv3dJT9H6BT9Xu3juu.FVmb1lNw04w1mFDbadmzGl/vdEcuK	6	9	Non Medis	ADE SASMITA, SE	aktif	\N	2026-04-15 08:30:11	2026-04-15 08:30:11
182	MUKHFI, AMD OT	20182443	mukhfi	mukhfi@rsazra.co.id	\N	$2y$12$gyZH2coLNyOldq22WaDCq.p/ss6LhRXZ8m.fFvOBthv64LOKze2eu	4	19	Medis	INTAN ANANDA UTAMI, Amd OT	aktif	\N	2026-04-15 08:30:11	2026-04-15 08:30:11
183	MULTAZAM SIDDIQ S, AMd Kes	20202746	multazam.siddiq	multazam.siddiq@rsazra.co.id	\N	$2y$12$A0MiUKNNfsWmcrXSquzgiuCp5qjn3srcfWuhee4h7EqoKralOHKCW	4	34	Medis	SEPTIAN NUGROHO, AMD.Rad	aktif	\N	2026-04-15 08:30:11	2026-04-15 08:30:11
184	MUTIARA AULIYAH SAFITRI, S.Kep., Ners	20222877	mutiara.auliyah	mutiara.auliyah@rsazra.co.id	\N	$2y$12$3MmCmmF7kXQmdMhdmZJ5xObfPazMpFZzsRBieK09iWbLS2aMfyly2	4	18	Medis	LESTARI RUMIYANI, S.Kep., Ns	aktif	\N	2026-04-15 08:30:12	2026-04-15 08:30:12
185	MUTIARA MARDIJJAH, S.I.Kom	19990365	mutiara.mardijjah	mutiara.mardijjah@rsazra.co.id	\N	$2y$12$9atHDIp9tJPXWS3Pg.c70e/FPggZSV70rpQ68xbor6qupikyaGBiy	4	20	Non Medis	TUMPAS BANGKIT PRAYUDA, SE	aktif	\N	2026-04-15 08:30:12	2026-04-15 08:30:12
186	NADIA RIZKIANA PUTRI, S.Tr.Kes	20222885	nadia.rizkiana	nadia.rizkiana@rsazra.co.id	\N	$2y$12$iRIbvMdLJUZJc/q5pX3.kejNHlD6tPxCElWohiUQeSRRf4VzS6QRO	4	29	Medis	INTAN ANANDA UTAMI, Amd OT	aktif	\N	2026-04-15 08:30:12	2026-04-15 08:30:12
187	NADILAH DWITA LESTARI, AMD.Kes	20242977	nadilah.dwita	nadilah.dwita@rsazra.co.id	\N	$2y$12$2mo4lKBKMjBk0QxIPRrqNunNBbTuRYbr/6LhxrudVFa000tcmkM.u	4	7	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:30:12	2026-04-15 08:30:12
188	NENENG NURJANAH, Amd TW	20242953	neneng.nurjanah	neneng.nurjanah@rsazra.co.id	\N	$2y$12$w1fJ8QqCzEy4L59.avL59e.mX7tn0Xfb0T9fsNd/XDtZt//Ay/p96	4	19	Medis	INTAN ANANDA UTAMI, Amd OT	aktif	\N	2026-04-15 08:30:13	2026-04-15 08:30:13
189	NGAKIF MUZAHID, AMD.T	20253076	ngakif.muzahid	ngakif.muzahid@rsazra.co.id	\N	$2y$12$LZMAu67Ss7/uQPdzjgc.Q.JkrLb6nrWOeugZ8W4tjMCthBLyZ2lD2	4	6	Non Medis	ALFIAN KURNIAWAN	aktif	\N	2026-04-15 08:30:13	2026-04-15 08:30:13
190	NIA TRY RAHAYU AGUSTINI, AMK	20081255	nia.try	nia.try@rsazra.co.id	\N	$2y$12$7JKyjq09GHYER12Ydhxt5ed1aEQUFYrNeFhEGzrDeTT.OwlfKWqF6	4	11	Medis	EKA SETIA WULANNINGSIH, S.Kep	aktif	\N	2026-04-15 08:30:13	2026-04-15 08:30:13
191	NIDA KHAIRUNNISA, S.Tr.Ds	20242950	nida.khairunnisa	nida.khairunnisa@rsazra.co.id	\N	$2y$12$Y8U2ihfzPej5npP.Sf9vnO6kOkpyFJ/y.PWHwZGAcvCvhQWE/k4cW	4	20	Non Medis	ANDRI IFTIYOKO, SH	aktif	\N	2026-04-15 08:30:13	2026-04-15 08:30:13
192	N. IDA LAELA RUBIANTI, AMK	20040752	n.ida	n.ida@rsazra.co.id	\N	$2y$12$jSV.s.VfXNMAxHATpbQNvu.mh7OgdlXv17Nd5xNFCZRRgjw5i3zrC	5	49	Medis	TETRIARIN CH. DARMO, AMK	aktif	\N	2026-04-15 08:30:13	2026-04-15 08:30:13
193	NIDA USSA’ADAH, AMD KEP	20202721	nida.ussa’adah	nida.ussa’adah@rsazra.co.id	\N	$2y$12$fm6jmX7JcHXpZaOML4dr7uFCscXu7Sk8P3r5XyDmGOmlw9Yg7fgAW	4	17	Medis	ANASTASIA DIAN PARLINA, S.Kep., Ners	aktif	\N	2026-04-15 08:30:14	2026-04-15 08:30:14
194	NOVI EKA ANDRIYANI, S.FARM., APT	20202709	novi.eka	novi.eka@rsazra.co.id	\N	$2y$12$hnrbagzoQzo8k5o92m1ureF4kcaDAeXhjTCoNOgs4940jz9l8Up9i	6	21	Medis	ELFA DIAN AGUSTINA, S.FARM, APT.	aktif	\N	2026-04-15 08:30:14	2026-04-15 08:30:14
195	NOVI YANTI, A.MD	20192621	novi.yanti	novi.yanti@rsazra.co.id	\N	$2y$12$HD5TRLFDpUnl4obdoAimZeP6/A1Oefm88vah5Dox7BupL7XrOaq36	4	43	Non Medis	M MAHFUD ISRO, S.E	aktif	\N	2026-04-15 08:30:14	2026-04-15 08:30:14
196	NURABILLA MAHARANI CAYADEWI, S.Tr.Kep., Ners	20253092	nurabilla.maharani	nurabilla.maharani@rsazra.co.id	\N	$2y$12$IAYBaCNlBkRbMyj4DAH7Je9.AyVHSO/Ihl9bBIpmuYrOxvkcxjJ52	4	13	Medis	SRI YULIANI, S.Kep., Ners	aktif	\N	2026-04-15 08:30:14	2026-04-15 08:30:14
197	NUR HALIMAH NASUTION, S.Kep., Ners	20253063	nur.halimah	nur.halimah@rsazra.co.id	\N	$2y$12$GydHkiy2gUBLEYMq9hsAiO2D3vOIYPcy3HbaukVHJygqtEMlWuyYa	4	10	Medis	EKA SETIA WULANNINGSIH, S.Kep	aktif	\N	2026-04-15 08:30:15	2026-04-15 08:30:15
198	NURHASAN	20030567	nurhasan	nurhasan@rsazra.co.id	\N	$2y$12$pFCNXlhtgogtKv1DERfl1.ne8LU/lk5xJSob.0uwenvwcgu7CqkC2	4	31	Non Medis	ALFIAN KURNIAWAN	aktif	\N	2026-04-15 08:30:15	2026-04-15 08:30:15
199	NURHASANAH, AMD TW	20050944	nurhasanah	nurhasanah@rsazra.co.id	\N	$2y$12$ocpCZr8n3zg97EKerA5ndek78rE3kVE/2OBLSlom9db5Yg4jybvp2	4	19	Medis	INTAN ANANDA UTAMI, AMD OT	aktif	\N	2026-04-15 08:30:15	2026-04-15 08:30:15
200	NURIKA IRFIYANI., AMD. TLM	20253011	nurika.irfiyani	nurika.irfiyani@rsazra.co.id	\N	$2y$12$gVl1Rr8pzzVYHk1alvhwj.wEDxxIdWS.zRQMjHKR65gL63NqUDLzW	4	8	Medis	ERNA SUNARNI, AMAK	aktif	\N	2026-04-15 08:30:15	2026-04-15 08:30:15
201	NURI NUR PADILAH, S. KEP., NERS	20242954	nuri.nur	nuri.nur@rsazra.co.id	\N	$2y$12$CP2DDG/4RFgaNSHN5ZCZXenB6pMHYJX9DfaplH1HeLCDAzkW8KmZy	4	16	Medis	YANTI HAPTIANI, S.KEP., NERS	aktif	\N	2026-04-15 08:30:15	2026-04-15 08:30:15
202	NURJANAH, AMKEB	20202735	nurjanah	nurjanah@rsazra.co.id	\N	$2y$12$GHzgFu3K.LwuncQ88GU4rOIl.1zikHkWITbOevJJm2Z1SnZDwYQky	4	44	Medis	IRENE SRI SUMARNI, AM.KEB	aktif	\N	2026-04-15 08:30:16	2026-04-15 08:30:16
203	NURLELA, AMD TW	20081216	nurlela	nurlela@rsazra.co.id	\N	$2y$12$9qF5mvBfF/eSa90dBBvt8ONGTcqb3w4uTHDODfd.PtbX8RH3rwNZ6	4	19	Medis	INTAN ANANDA UTAMI, AMD OT	aktif	\N	2026-04-15 08:30:16	2026-04-15 08:30:16
204	NUR RAVICA APRILIA, S. KEP., NERS	20253082	nur.ravica	nur.ravica@rsazra.co.id	\N	$2y$12$3NMeiZiTZHBwU4lrXlqVwuRL3i1epBBJI5OjMZwCdXcwvA.RiuEqS	4	13	Medis	SRI YULIANI, S.KEP., NERS	aktif	\N	2026-04-15 08:30:16	2026-04-15 08:30:16
205	NUR ULFA DEWI, AMK	20081292	nur.ulfa	nur.ulfa@rsazra.co.id	\N	$2y$12$hf6GYEfg6CDED6FuFjR5B.ic3L.HLAIlyt3vV/AKgSLQIjSTjop6W	4	18	Medis	LESTARI RUMIYANI, S.KEP., NS	aktif	\N	2026-04-15 08:30:16	2026-04-15 08:30:16
206	NURUL INDRIYANI, A MD. KEP	20212777	nurul.indriyani	nurul.indriyani@rsazra.co.id	\N	$2y$12$uqD0DkM1rsrtCNc07qC70ODx8T.XfcPGM6g5L8KrJ/SQgD/HP9vhO	4	16	Medis	YANTI HAPTIANI, S.KEP., NERS	aktif	\N	2026-04-15 08:30:17	2026-04-15 08:30:17
207	NURUL SOBAH, AMD. FARM	20202711	nurul.sobah	nurul.sobah@rsazra.co.id	\N	$2y$12$sU3ucoaifL6gqOlCEbWnTuEmpPnlqKcedbPG4oYjmu0BpAjc6mErO	4	21	Medis	ELFA DIAN AGUSTINA, S.FARM, APT.	aktif	\N	2026-04-15 08:30:17	2026-04-15 08:30:17
208	OPI DAMAHYANTI, S.FARM., APT	20242939	opi.damahyanti	opi.damahyanti@rsazra.co.id	\N	$2y$12$Vux4QPzzqxgYXOGm0sB3/ubx.5QwnLxNDjPVxbcw5bHzi9sLhY5.a	4	21	Medis	ELFA DIAN AGUSTINA, S.FARM, APT.	aktif	\N	2026-04-15 08:30:17	2026-04-15 08:30:17
209	PAHLEVI MARVELINO SIBORUTOROP., DR	20253081	pahlevi.marvelino	pahlevi.marvelino@rsazra.co.id	\N	$2y$12$IHm6yROlaWOzXC2aGNx22up8EaxkblUDZkZ5GXddPqbOKYptCrM2u	4	32	Medis	MUHAMMAD ARDYANSYAH PRATAMA, DR	aktif	\N	2026-04-15 08:30:17	2026-04-15 08:30:17
210	PANJI MARIJAN FIRDAUS, S.FARM	20202686	panji.marijan	panji.marijan@rsazra.co.id	\N	$2y$12$phP4D3Wvp6uJ6zgjUH8Wa.pqWhe8/ZgK04ogTjqtummUYjPXiwnUm	4	21	Medis	ELFA DIAN AGUSTINA, S.FARM, APT.	aktif	\N	2026-04-15 08:30:17	2026-04-15 08:30:17
211	PARIDA PEBRUANTI, S. KEP., NERS	20242938	parida.pebruanti	parida.pebruanti@rsazra.co.id	\N	$2y$12$VWrZicdZorhP.wEwwlvmk.wL2p1kZ6PlEin1gBSXKRRk85OzERnJu	4	18	Medis	LESTARI RUMIYANI, S.KEP., NS	aktif	\N	2026-04-15 08:30:18	2026-04-15 08:30:18
212	PATRICIA LUMINDA BATUBARA, DR	20050919	patricia.luminda	patricia.luminda@rsazra.co.id	\N	$2y$12$8oMtMzNdrOnBT6sQv.OUA.VasJQPKYgiBbyKbM5K43MSkt9jbmzJK	4	32	Medis	MUHAMMAD ARDYANSYAH PRATAMA, DR	aktif	\N	2026-04-15 08:30:18	2026-04-15 08:30:18
213	PINA HARYANTI., AMD.FARM	20253037	pina.haryanti	pina.haryanti@rsazra.co.id	\N	$2y$12$k9c5cSBQ6khdRao41t6wNuc1ttB2RCaNzsCW2bDowQYY4wj1yzmjG	4	21	Medis	ELFA DIAN AGUSTINA, S.FARM, APT.	aktif	\N	2026-04-15 08:30:18	2026-04-15 08:30:18
214	PUJI ASTUTI, AMK	20061051	puji.astuti	puji.astuti@rsazra.co.id	\N	$2y$12$gvgAFYupkyeHlqD5szP77ehtX1AWCiyOR8QcLbU0LLBn6JLk07X32	5	49	Medis	TETRIARIN CH. DARMO, AMK	aktif	\N	2026-04-15 08:30:18	2026-04-15 08:30:18
215	PUTRY SUSILOWATI, AM.KEB	20202745	putry.susilowati	putry.susilowati@rsazra.co.id	\N	$2y$12$RmZxXASVDUnG2pM7v39AtuvjMWwDwvCYMnE9WnQzovPaoZPUAX0U2	4	7	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:30:19	2026-04-15 08:30:19
216	QORI FADILAH, SST	20202689	qori.fadilah	qori.fadilah@rsazra.co.id	\N	$2y$12$5zy1ksMmqxpaNaBB2xFnDuc5bBtF6lfvVF1Sx6GT4BR7XuxGr.k1S	4	44	Medis	IRENE SRI SUMARNI, AM.KEB	aktif	\N	2026-04-15 08:30:19	2026-04-15 08:30:19
217	RACHEL JIHAN KAMILA, S.M	20222900	rachel.jihan	rachel.jihan@rsazra.co.id	\N	$2y$12$TTzY/mfKVFMYnEwmo0K8ie.Z449ZRh8mhwS7/6KHbS57HdV/OlQEC	4	30	Non Medis	BUDI HARTANTO	aktif	\N	2026-04-15 08:30:19	2026-04-15 08:30:19
218	RAFIKA ZAHRA, S.KEP., NERS	20253032	rafika.zahra	rafika.zahra@rsazra.co.id	\N	$2y$12$xhToGGEsrVYmbQ8vfwppU.jmYawC99cG.F5jjtVsk79BMJBHgb8bW	4	10	Medis	EKA SETIA WULANNINGSIH, S.KEP	aktif	\N	2026-04-15 08:30:19	2026-04-15 08:30:19
219	RAHAYU AFIAH SURUR, DR	20253051	rahayu.afiah	rahayu.afiah@rsazra.co.id	\N	$2y$12$Qy7k6c9wF7pbvDAg2j1rNOIJHhNIWJHXQlz0K2wpbmYODgi6Kn1vC	8	45	Non Medis	LILI MARLIANI, DR., MARS	aktif	\N	2026-04-15 08:30:19	2026-04-15 08:30:19
220	RAHAYU PUSPAWANDARI, DR	20253064	rahayu.puspawandari	rahayu.puspawandari@rsazra.co.id	\N	$2y$12$aNQVLPhsntv68SQqeT38m.Idmiox/B5thnE8dkq.IvecNJv3l91sm	4	32	Medis	MUHAMMAD ARDYANSYAH PRATAMA, DR	aktif	\N	2026-04-15 08:30:20	2026-04-15 08:30:20
221	RAIMOND ANDROMEGA, DR., M.P.H	20253086	raimond.andromega	raimond.andromega@rsazra.co.id	\N	$2y$12$OZTZT1Pcl/e/Eyxdm44/tOcdlMXB7sZqGDkNm.utfVrgGUk2NAYCy	9	26	Non Medis	LILI MARLIANI, DR., MARS	aktif	\N	2026-04-15 08:30:20	2026-04-15 08:30:20
222	RAKEUN MAYANG MUTIARA, S.FARM	20253058	rakeun.mayang	rakeun.mayang@rsazra.co.id	\N	$2y$12$LxUJFvJo4VPJHGICIQG0H.aUPwrOvHSCtiPViH9ZhlKNJvDt4paMi	4	21	Medis	ELFA DIAN AGUSTINA, S.FARM, APT.	aktif	\N	2026-04-15 08:30:20	2026-04-15 08:30:20
223	RANDILUFTI SANTOSO, DR	20212773	randilufti.santoso	randilufti.santoso@rsazra.co.id	\N	$2y$12$ARqM.qB450mNK.tle5gbQuFHa1m8o/1LR2BiUcoNvgE1/.DwpxXMm	4	32	Medis	MUHAMMAD ARDYANSYAH PRATAMA, DR	aktif	\N	2026-04-15 08:30:20	2026-04-15 08:30:20
224	RANTI AGUSTIANI, AMD KEP	20192558	ranti.agustiani	ranti.agustiani@rsazra.co.id	\N	$2y$12$YJ4DEeUO9y.uaoJyqrhJkuKpY1DPRShAR0mEZ7hkpG3fc9ecwDche	4	17	Medis	ANASTASIA DIAN PARLINA, S.KEP., NERS	aktif	\N	2026-04-15 08:30:21	2026-04-15 08:30:21
225	RARAS OCVERTYA., A. MD	20192618	raras.ocvertya	raras.ocvertya@rsazra.co.id	\N	$2y$12$EamdpBqJDSuK/.crDWeR6erBzr5Kb.dKTEj40hr9BAYGxgg6KSI.C	4	37	Non Medis	REGAWA PARRIKESIT., A. MD	aktif	\N	2026-04-15 08:30:21	2026-04-15 08:30:21
226	RATNA NURHAYATI, AMK	20091320	ratna.nurhayati	ratna.nurhayati@rsazra.co.id	\N	$2y$12$o6zk.YppqL8BhuXhlrDCG.8Z51r2g5NLjjRHL0TtvyTXaIeXi9Ssi	4	22	Medis	SAMSIAH, S.KEP., NERS	aktif	\N	2026-04-15 08:30:21	2026-04-15 08:30:21
227	RATNA PURI, AMD KEP	20212788	ratna.puri	ratna.puri@rsazra.co.id	\N	$2y$12$JaY4aurdfv.6oyUV3sdlluzY5q2tHC8Dvdj8/Ei0jJ/MkffBmrqVW	4	13	Medis	SRI YULIANI, S.KEP., NERS	aktif	\N	2026-04-15 08:30:21	2026-04-15 08:30:21
228	RATU SELPI CAHYANTI, AMD AK	20192541	ratu.selpi	ratu.selpi@rsazra.co.id	\N	$2y$12$08FDLlFkZ/ceWazzLpTE8O2zir.p58FEP/ouvMlOgLyPR2P13g8qe	4	8	Medis	ERNA SUNARNI, AMAK	aktif	\N	2026-04-15 08:30:21	2026-04-15 08:30:21
229	REGAWA PARRIKESIT., A. MD	20192650	regawa.parrikesit	regawa.parrikesit@rsazra.co.id	\N	$2y$12$rOi9t7NOneUMd46O0VJrMet9DuHodL8/WjYdrRPUOYeK5q1F3R9rK	5	37	Non Medis	TUMPAS BANGKIT PRAYUDA., SE	aktif	\N	2026-04-15 08:30:22	2026-04-15 08:30:22
230	RENA FARHAH, AMD KEP	20192561	rena.farhah	rena.farhah@rsazra.co.id	\N	$2y$12$sbQs2qGAe0fM1nfDjZkBO.cDDz9BiqSCB4wW15pAPo4y5CBuxq5L6	4	7	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:30:22	2026-04-15 08:30:22
231	RENI CAHYANTI, AM.KEB	20040674	reni.cahyanti	reni.cahyanti@rsazra.co.id	\N	$2y$12$tbLG6pbOHL7urlp6kH.mfuOsUaZJFtbM2OuNwchNr.KMQqYXhIkQq	4	44	Medis	IRENE SRI SUMARNI, AM.KEB	aktif	\N	2026-04-15 08:30:22	2026-04-15 08:30:22
232	RENY MULYASARI, AMK	20081172	reny.mulyasari	reny.mulyasari@rsazra.co.id	\N	$2y$12$vGXv3osZRrYCkzXdIPvQze4GERXBz8BEDKv7e/HZpdflYLS7woc3.	6	14	Medis	SRI YULIANI, S.KEP., NERS	aktif	\N	2026-04-15 08:30:22	2026-04-15 08:30:22
233	RESTI FEBRIYANTI, AMD KES	20202755	resti.febriyanti	resti.febriyanti@rsazra.co.id	\N	$2y$12$zboYNVxPtdDIPsCsX6i6Pet6UVuPq1fz4uuwo/T5fyL.m2nNMRWT.	4	8	Medis	ERNA SUNARNI, AMAK	aktif	\N	2026-04-15 08:30:23	2026-04-15 08:30:23
234	RETNA RAHAYUNINGSIH, AM.KEB	20020417	retna.rahayuningsih	retna.rahayuningsih@rsazra.co.id	\N	$2y$12$3aJHqC/SUhLXW1q.L6w8zOVRKNrYNkZYTAywL97cmzQxMUYB.FQQ6	4	44	Medis	IRENE SRI SUMARNI, AM.KEB	aktif	\N	2026-04-15 08:30:23	2026-04-15 08:30:23
235	RHISMA HILDA PRAWITA, STR. KL	20172355	rhisma.hilda	rhisma.hilda@rsazra.co.id	\N	$2y$12$RaOl1o3RoqC6fz/l5lkvoeyPzY6p9342RAYDWNDf8qMYKBjgaKwr6	6	46	Non Medis	ADE IRPAN, SKM	aktif	\N	2026-04-15 08:30:23	2026-04-15 08:30:23
236	RICKY ADI PRATAMA, S.M	20222898	ricky.adi	ricky.adi@rsazra.co.id	\N	$2y$12$SscbmmzrIZgg5jQYKloV/uralegFet6hoyZ8NVsEe/6vfmF4kCnBO	4	30	Non Medis	BUDI HARTANTO	aktif	\N	2026-04-15 08:30:23	2026-04-15 08:30:23
237	RIKA RAMDAYANTI, S.M	20202677	rika.ramdayanti	rika.ramdayanti@rsazra.co.id	\N	$2y$12$qRRxmghvvhSiF8QFbt8nTuQQdM0rDKcSXZyvXDnepFrV0EBw..Lp6	4	40	Non Medis	RIA FAJARROHMI, SE	aktif	\N	2026-04-15 08:30:24	2026-04-15 08:30:24
238	RINA AYU APRILIANTI, AMD AK	20182412	rina.ayu	rina.ayu@rsazra.co.id	\N	$2y$12$TE80OCwcVbc5MbhjeFEDGenqPs.yg4uK./muKuDkgeQ024cYScS.G	4	8	Medis	ERNA SUNARNI, AMAK	aktif	\N	2026-04-15 08:30:24	2026-04-15 08:30:24
239	RINA REDAWATI, AM.KEB	20172252	rina.redawati	rina.redawati@rsazra.co.id	\N	$2y$12$gxoDQLf7vUqkK1dLvSMUHuouOb2V86HovRVP25KKTWOmY256vuive	4	7	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:30:24	2026-04-15 08:30:24
240	RINDI KOMALASARI, S.KEP., NERS	20253061	rindi.komalasari	rindi.komalasari@rsazra.co.id	\N	$2y$12$8w/eh.z..yLNVHN925v0fuxKbvQLmqT0LCUMwUuo7YaSFiVeqMs9.	4	18	Medis	LESTARI RUMIYANI, S.KEP., NS	aktif	\N	2026-04-15 08:30:24	2026-04-15 08:30:24
241	RISANTI MARYONO, S.KEP., NERS	20081313	risanti.maryono	risanti.maryono@rsazra.co.id	\N	$2y$12$zlbPzg9gasT9j3xze85EQ.lZm9WpYHJAKHz5SM.86IY53WwzH4Fle	4	18	Medis	LESTARI RUMIYANI, S.KEP., NS	aktif	\N	2026-04-15 08:30:24	2026-04-15 08:30:24
242	RISA NUR FADILLA., S. TR. KES	20253012	risa.nur	risa.nur@rsazra.co.id	\N	$2y$12$mB.9AGbRb9hjM.Wa4PAdauUYs8sDW7fiYAa7Kd2fACHT95i226Zra	4	8	Medis	ERNA SUNARNI, AMAK	aktif	\N	2026-04-15 08:30:25	2026-04-15 08:30:25
243	RITA FITRIANI, AMKG	20040741	rita.fitriani	rita.fitriani@rsazra.co.id	\N	$2y$12$BmgyyHqmJ8FGpopcTEUduOAosiR6H3sPdBqVNZVhF7DWTajZdMPB.	4	7	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:30:25	2026-04-15 08:30:25
244	RIZA SUKMA SARI, AMD	20040827	riza.sukma	riza.sukma@rsazra.co.id	\N	$2y$12$/V9L79sPOEBO2OZaBd.Yj./OnWfK8/5LGS4MsYqxCFoZPW.byQDE2	4	21	Medis	ELFA DIAN AGUSTINA, S.FARM, APT.	aktif	\N	2026-04-15 08:30:25	2026-04-15 08:30:25
245	RIZKI WICAKSONO, DR	20172374	rizki.wicaksono	rizki.wicaksono@rsazra.co.id	\N	$2y$12$R4VZQ9w6auAknyV/5CgpD.BqbdJltYluTo6IlqQkr8UiiQrkEP53O	6	32	Medis	MUHAMMAD ARDYANSYAH PRATAMA, DR	aktif	\N	2026-04-15 08:30:25	2026-04-15 08:30:25
246	R. MAMAT HERMANSYAH, S.TR.KES	19960285	r.mamat	r.mamat@rsazra.co.id	\N	$2y$12$8tODLXkbFHmxuQRFR7UZ/ONXYJNC/7tt5M9pPDUdn0o5gYqlkzZ1q	4	29	Medis	INTAN ANANDA UTAMI, AMD OT	aktif	\N	2026-04-15 08:30:26	2026-04-15 08:30:26
247	ROKA MALLA, AMD FT	20182431	roka.malla	roka.malla@rsazra.co.id	\N	$2y$12$gdliwIBRauH4yc9j80gXb.PVSrm.fO7fv59hXp8Vlkp8i/6htvpu.	4	19	Medis	INTAN ANANDA UTAMI, AMD OT	aktif	\N	2026-04-15 08:30:26	2026-04-15 08:30:26
248	ROSALIA BR. PURBA, S. KEP., NS	20020428	rosalia.br	rosalia.br@rsazra.co.id	\N	$2y$12$UxOkwjAJwh0VEQJlcTXDWe/gq75Zma7QAP0mb5xAMYjaDKJE./Rui	4	7	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:30:26	2026-04-15 08:30:26
249	RUSLI	19940117	rusli	rusli@rsazra.co.id	\N	$2y$12$98W1ucyEc6hGsGrJAcEEluzZealDix.kQ4/PN4XG8pNtEVYwOwpnu	4	47	Non Medis	RIYADI MAULANA, SH., MH., CLA., CCD	aktif	\N	2026-04-15 08:30:26	2026-04-15 08:30:26
250	RYAN KHUNAM ALAMHARI, S. FARM	20232920	ryan.khunam	ryan.khunam@rsazra.co.id	\N	$2y$12$WwNLjGQJRjPNVN/5skkZX.x4aI39wCQp9cUaVbbTyFP8jG0EMCYmu	4	21	Medis	ELFA DIAN AGUSTINA, S.FARM, APT.	aktif	\N	2026-04-15 08:30:27	2026-04-15 08:30:27
251	SAHILA RIZKIA, AMD GZ	20222887	sahila.rizkia	sahila.rizkia@rsazra.co.id	\N	$2y$12$BCTafeCjPkp.SQpRzKSePuLdUyDKIj9euhYpa4kwPTpDyOFLlmG8q	4	3	Medis	KHANZA RIRI ARISTIANI, S.GZ	aktif	\N	2026-04-15 08:30:27	2026-04-15 08:30:27
252	SAINT RYALIN FIRDAUS, AMD. KEB	20242980	saint.ryalin	saint.ryalin@rsazra.co.id	\N	$2y$12$HNwKly3D3RjClUWez3dpSOQAV83gjvnrJPN/fGvy/m6sBdpB6E/A6	4	44	Medis	IRENE SRI SUMARNI, AM.KEB	aktif	\N	2026-04-15 08:30:27	2026-04-15 08:30:27
253	SALMA AHSANIAWATI, S.KEP., NERS	20253055	salma.ahsaniawati	salma.ahsaniawati@rsazra.co.id	\N	$2y$12$ZfhBptF3spi0pK3GHxXenOBuzO4j7/wWqh3KjVrAbhh0unbHMTZmm	4	12	Medis	SRI YULIANI, S.KEP., NERS	aktif	\N	2026-04-15 08:30:27	2026-04-15 08:30:27
254	SALSABILLA AULIA JATMIKO, S. TR. KEP., NERS	20253056	salsabilla.aulia	salsabilla.aulia@rsazra.co.id	\N	$2y$12$aKDtQTzc5ZSq.x7TaGXgsOU53Ee6NVtjSKdXkBFxCl8ggDo2brbBi	4	18	Medis	LESTARI RUMIYANI, S.KEP., NS	aktif	\N	2026-04-15 08:30:27	2026-04-15 08:30:27
255	SAMSIAH, S.KEP., NERS	20020434	samsiah	samsiah@rsazra.co.id	\N	$2y$12$NJqgFM3Wv4nppqL4yODNG.00Vsa88S.k4FUBAblJlrx10FGxN4oZ2	5	22	Medis	SENI MAULIDA FITALOKA, S.KEP., NS, M.KEP	aktif	\N	2026-04-15 08:30:28	2026-04-15 08:30:28
256	SAMSON FEMI EFFENDI	20040801	samson.femi	samson.femi@rsazra.co.id	\N	$2y$12$KaMJLl3.mjt1ewganyfOaO5slGnN7oHubuOw7al57O0kjt0fHzmLe	4	48	Non Medis	ADE IRPAN, SKM	aktif	\N	2026-04-15 08:30:28	2026-04-15 08:30:28
257	SANDY PERMANA	20212763	sandy.permana	sandy.permana@rsazra.co.id	\N	$2y$12$V3hn3j7dX4n3nMuYT4w51O5fY2u0.keagfU5AukTzE0Dw1acb9JPm	4	30	Non Medis	BUDI HARTANTO	aktif	\N	2026-04-15 08:30:28	2026-04-15 08:30:28
258	SANI INDRAYANA, AMAK	20040754	sani.indrayana	sani.indrayana@rsazra.co.id	\N	$2y$12$GwnhF6kLW1mjsSurtrt5WOLDuIUB5eFqc5iZ9qcdpcE4HbucENpDC	4	8	Medis	ERNA SUNARNI, AMAK	aktif	\N	2026-04-15 08:30:28	2026-04-15 08:30:28
259	SARI ROHATI, AMK	19950207	sari.rohati	sari.rohati@rsazra.co.id	\N	$2y$12$cRFwK29DdEJr/DHz//DNOe8yd.4OXQrFT9SdH3iSuBHMNtTZvFSyC	4	33	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:30:29	2026-04-15 08:30:29
260	SARSILAH, S.KEP., NERS	20111609	sarsilah	sarsilah@rsazra.co.id	\N	$2y$12$Z7DzFhpL9djQHNavmf6beOqEAT8mHXCz/BetY0ux9VhCZOuJr3viy	4	17	Medis	ANASTASIA DIAN PARLINA, S.KEP., NERS	aktif	\N	2026-04-15 08:30:29	2026-04-15 08:30:29
261	SATRIO GILANG PRATAMA, S.KEP., NERS	20253079	satrio.gilang	satrio.gilang@rsazra.co.id	\N	$2y$12$69u0zzMmi6SVsJGSG93J7ucb0XlwxrjMLDJ./Sk8JkkOdVALaGrTi	4	12	Medis	SRI YULIANI, S.KEP., NERS	aktif	\N	2026-04-15 08:30:29	2026-04-15 08:30:29
262	SEKAR AYU WULANDARI, AMD KEP	20192583	sekar.ayu	sekar.ayu@rsazra.co.id	\N	$2y$12$qGRDlulWvzksAOAq9n7BmebbOlbGhAo4vBzDYCkry0/WEXSLYHcwW	4	16	Medis	YANTI HAPTIANI, S.KEP., NERS	aktif	\N	2026-04-15 08:30:29	2026-04-15 08:30:29
263	SELLY LESTIANA, S.SI., APT	20202685	selly.lestiana	selly.lestiana@rsazra.co.id	\N	$2y$12$e3nxRFKjkoxVJMm6Kf53S.SNdfSEUaSEi2z5nUDOb6FEeERktpQYe	4	21	Medis	ELFA DIAN AGUSTINA, S.FARM, APT	aktif	\N	2026-04-15 08:30:30	2026-04-15 08:30:30
264	SENY SETIAWANTI, AMD KEP	20202694	seny.setiawanti	seny.setiawanti@rsazra.co.id	\N	$2y$12$Sxgvr3dKxn9dt3Itx4RlO.a39N1sjQL4W8I1zuwmsUTYsxvi9N5hO	4	17	Medis	ANASTASIA DIAN PARLINA, S.KEP., NERS	aktif	\N	2026-04-15 08:30:30	2026-04-15 08:30:30
265	SEPTIAN NUGROHO, AMD. RAD	20091380	septian.nugroho	septian.nugroho@rsazra.co.id	\N	$2y$12$koJ0Uvb785fQIDFub.e03.db3lKp7wQ3IbkwnT/RiqMdiy795oceW	5	34	Medis	GARCINIA SATIVA FIZRIA SETIADI, DR., MKM	aktif	\N	2026-04-15 08:30:30	2026-04-15 08:30:30
266	SETIADI, DR	20253029	setiadi	setiadi@rsazra.co.id	\N	$2y$12$vfOSE8gJqC0SNCabwx6i2OkUTe9DB4uMO.ANWqW17fvd/egT84axa	4	32	Medis	MUHAMMAD ARDYANSYAH PRATAMA, DR	aktif	\N	2026-04-15 08:30:30	2026-04-15 08:30:30
267	SHINTA KUSUMA WARDANI, S.KEP., NERS	20222846	shinta.kusuma	shinta.kusuma@rsazra.co.id	\N	$2y$12$W4zvVowNTqCHIRhLWqnU5e9kVOGXN8lAgpl8o8U/aO4qb1zDN4l.6	4	15	Medis	YANTI HAPTIANI, S.KEP., NERS	aktif	\N	2026-04-15 08:30:30	2026-04-15 08:30:30
268	SINTIA RESTU DEVI, AMD KEP	20192557	sintia.restu	sintia.restu@rsazra.co.id	\N	$2y$12$lpGg2YJkzyjVVsDqdCMO6uq5l8E7fhg0atqbSpxgGEbxrC2eoiZX2	4	7	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:30:31	2026-04-15 08:30:31
269	SISCA AMALIAH	20253048	sisca.amaliah	sisca.amaliah@rsazra.co.id	\N	$2y$12$vMbca8XtdF2SMYm2TBwFYuKXFr2wxt5smAw7rwUzlwAYhOHVsCHDK	4	26	Medis	RAIMOND ANDROMEGA, DR., M.P.H	aktif	\N	2026-04-15 08:30:31	2026-04-15 08:30:31
270	SISCHA, S. FARM	20202712	sischa	sischa@rsazra.co.id	\N	$2y$12$Fu2x/UsaLHyS2K1YtSJuIeuSVVayrBV2B6fHKzMERnaa3AFG3FtBq	4	21	Medis	ELFA DIAN AGUSTINA, S.FARM, APT	aktif	\N	2026-04-15 08:30:31	2026-04-15 08:30:31
271	SITA AISAH ANGGITA, S. SOS	20232918	sita.aisah	sita.aisah@rsazra.co.id	\N	$2y$12$yYTJBGPIX3Gde93mCNwkyuSWUJg7BNquH/4ft29chhzyY0r.e0Fwa	4	20	Non Medis	ANDRI IFTIYOKO, SH	aktif	\N	2026-04-15 08:30:31	2026-04-15 08:30:31
272	SITAH UMU HAKIM, AMK	20040852	sitah.umu	sitah.umu@rsazra.co.id	\N	$2y$12$2sOx6e0TOvxqUw86rRBJzesUaSek/wAjqPfBpU1qC9fAhqD/XR7Ua	5	50	Medis	SENI MAULIDA FITALOKA, S.KEP., NERS, M.KEP	aktif	\N	2026-04-15 08:30:32	2026-04-15 08:30:32
273	SITI NUR HIDAYAH, AMD KEP	20182495	siti.nur	siti.nur@rsazra.co.id	\N	$2y$12$vtLYPtWcqIW/SiKZGyrUgePw9XTjC.lTMvo5H0q.3mnnmGzcAy79G	4	13	Medis	SRI YULIANI, S.KEP., NERS	aktif	\N	2026-04-15 08:30:32	2026-04-15 08:30:32
274	SITI NURMILAH, S.KEP., NERS	20242931	siti.nurmilah	siti.nurmilah@rsazra.co.id	\N	$2y$12$9pEZa6qT7rtClJe0bGbO7u3CP.YQdQteDcPAEvKoJcaZQamMOY/26	4	15	Medis	YANTI HAPTIANI, S.KEP., NERS	aktif	\N	2026-04-15 08:30:32	2026-04-15 08:30:32
275	SITI SARI WULANDARI, S.KEP., NERS	20253067	siti.sari	siti.sari@rsazra.co.id	\N	$2y$12$NGAhQRh3YFf7lVVD6U4IV.L9WeZwtJUKYTQL7HpAacZiR67gR.MEa	4	7	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:30:32	2026-04-15 08:30:32
276	SOBUR SETIAWAN, S.KEP., NERS	20222881	sobur.setiawan	sobur.setiawan@rsazra.co.id	\N	$2y$12$qKKiWypyUuXb5Bitoh23Yub.n4EE3nHKSRoK1/dff/UoG6GXmUiiC	4	14	Medis	SRI YULIANI, S.KEP., NERS	aktif	\N	2026-04-15 08:30:32	2026-04-15 08:30:32
277	SOEPARNO, AMD.PERKES., S.MIK	20040795	soeparno	soeparno@rsazra.co.id	\N	$2y$12$wxKphvO8cTFmTwPz62u5huLXBCB8fWy/3zXrT/9rCRnysg3laxsCe	5	41	Medis	GARCINIA SATIVA FIZRIA SETIADI, DR., MKM	aktif	\N	2026-04-15 08:30:33	2026-04-15 08:30:33
278	SRI ANNISA NURAENI, AMK	20192624	sri.annisa	sri.annisa@rsazra.co.id	\N	$2y$12$o9IHrdDXy6iA1XRsJ.1xWuU.A4yiz6D74huch96iZ1V08m7B5HF8O	4	13	Medis	SRI YULIANI, S.KEP., NERS	aktif	\N	2026-04-15 08:30:33	2026-04-15 08:30:33
279	SRI FATMIANI, AMD	20121748	sri.fatmiani	sri.fatmiani@rsazra.co.id	\N	$2y$12$6ngw5ce.l1INVBVFhnG5YuCrRHh7lib295fPbQO4bfqV2.NVQ.jHy	4	3	Medis	KHANZA RIRI ARISTIANI, S.GZ	aktif	\N	2026-04-15 08:30:33	2026-04-15 08:30:33
280	SRI LESTARI DAMAYANTI, S.KEP., NERS	20212765	sri.lestari	sri.lestari@rsazra.co.id	\N	$2y$12$HwGm974xRII9EQRffluGeuHXDhB7VI26iTCdyDdsq0/NIR82ubPUS	4	13	Medis	SRI YULIANI, S.KEP., NERS	aktif	\N	2026-04-15 08:30:33	2026-04-15 08:30:33
281	SRI NURHAYATI, AMAK	20172357	sri.nurhayati	sri.nurhayati@rsazra.co.id	\N	$2y$12$zBpnV9YAR4M6vQHgCYnC2eeYXPGFtyzkRdnDWWME/N4/BxVbYeeCG	4	8	Medis	ERNA SUNARNI, AMAK	aktif	\N	2026-04-15 08:30:33	2026-04-15 08:30:33
282	SRI WAHYULI, A. MD	20162170	sri.wahyuli	sri.wahyuli@rsazra.co.id	\N	$2y$12$NVUNdWqMcqlz1lrRat7NBOcbA7mIRWKNl8LmIrHR17ibfwkjx04XW	4	30	Non Medis	BUDI HARTANTO	aktif	\N	2026-04-15 08:30:34	2026-04-15 08:30:34
283	SRI YULIANI, S.KEP., NERS	20101419	sri.yuliani	sri.yuliani@rsazra.co.id	\N	$2y$12$qlC/5Bujd7s1OCmGSTHT6Ox1OvOFNhs0gbVJ9T/Ic0F0Zb7n231Ta	5	12	Medis	SENI MAULIDA FITALOKA, S.KEP., NERS, M.KEP	aktif	\N	2026-04-15 08:30:34	2026-04-15 08:30:34
284	SUGIONO	19960284	sugiono	sugiono@rsazra.co.id	\N	$2y$12$2bTr2xAGRBnEJCfdlIRS/OMDFmip9oqnrm6SITNjsQqhpfkpzLqfe	4	51	Medis	ADE IRPAN, SKM	aktif	\N	2026-04-15 08:30:34	2026-04-15 08:30:34
285	SUHAERIYAH, S.FARM	20253042	suhaeriyah	suhaeriyah@rsazra.co.id	\N	$2y$12$jWWY2ovN2.5VemiFIVehWuosKj1gf0dQAn6Wa/AIeyWfbvG8J8eeW	4	21	Non Medis	ELFA DIAN AGUSTINA, S.FARM, APT	aktif	\N	2026-04-15 08:30:34	2026-04-15 08:30:34
286	SUHERMAN, S.KEP	20253080	suherman	suherman@rsazra.co.id	\N	$2y$12$T9zXQr.zvlvsWxKwlQmavugGeQVx7zRPWG8LNves7Rtb1Wu9vDEDO	4	27	Medis	DIAN MAHDIANI, S.KEP., NERS	aktif	\N	2026-04-15 08:30:35	2026-04-15 08:30:35
287	SUMAYYAH FITRI KARIMAH, AMD KEB	20212834	sumayyah.fitri	sumayyah.fitri@rsazra.co.id	\N	$2y$12$HOVAeFdtQZFP6pzLXJqaNuc/nStF05Cooi5veWj.GngPoGcU/FbWO	4	44	Medis	IRENE SRI SUMARNI, AM.KEB	aktif	\N	2026-04-15 08:30:35	2026-04-15 08:30:35
288	SUNARDI	19950219	sunardi	sunardi@rsazra.co.id	\N	$2y$12$EI3ZUNjWTr5rbjDCS9ji0./YkwS9LhZ5x0L7cpUYGW1qV24LL/DJi	4	51	Medis	ADE IRPAN, SKM	aktif	\N	2026-04-15 08:30:35	2026-04-15 08:30:35
289	SUPADMI, AMAK	19950176	supadmi	supadmi@rsazra.co.id	\N	$2y$12$mzganl0MYGkfqF80wGRnP.vmGYpfR./13clWuyfqW2JCx0VGof2iK	4	8	Medis	ERNA SUNARNI, AMAK	aktif	\N	2026-04-15 08:30:35	2026-04-15 08:30:35
290	SURYADI, SE	20192616	suryadi	suryadi@rsazra.co.id	\N	$2y$12$uQF.KGSG5xBF8BIcYSZoEe0mbGvKnoArtN0C6IsTFuBeNPA8KjbDi	4	43	Non Medis	HADI KURNIAWAN, S.M	aktif	\N	2026-04-15 08:30:36	2026-04-15 08:30:36
291	SYAIDA ROHMANI, AMD FT	20121845	syaida.rohmani	syaida.rohmani@rsazra.co.id	\N	$2y$12$0Ldkmf4Mzzy.pu5or4HS4uEQCMz.zY50aV/Jp80ZnJHXgeeEEEtYu	6	29	Medis	INTAN ANANDA UTAMI, AMD OT	aktif	\N	2026-04-15 08:30:36	2026-04-15 08:30:36
292	TANTI NURIYANTI, S.KEP	20202682	tanti.nuriyanti	tanti.nuriyanti@rsazra.co.id	\N	$2y$12$IR1ij8JRLTuDnUp1/73PHu/sR1GQm3XCDXDId6uBxBH8QbaMyYapG	6	27	Medis	DIAN MAHDIANI, S.KEP., NERS	aktif	\N	2026-04-15 08:30:36	2026-04-15 08:30:36
293	TANTY HERDIYANI, DR. SP.PK	20162109	tanty.herdiyani	tanty.herdiyani@rsazra.co.id	\N	$2y$12$dpflnirgb6zFglaoKQ1a1eDk7EHJ8fY3/a2Nvgbjo/MJyUguNiTTi	10	8	Medis	GARCINIA SATIVA FIZRIA SETIADI, DR., MKM	aktif	\N	2026-04-15 08:30:36	2026-04-15 08:30:36
294	TARY SHINTYA SOPANDI, S. PD	20232926	tary.shintya	tary.shintya@rsazra.co.id	\N	$2y$12$yjWRFmFSXg4A2a/IDk3rquk9rI/RxTFB3qjP18mg1k3k1zfmxSdlG	4	40	Non Medis	RIA FAJARROHMI, SE	aktif	\N	2026-04-15 08:30:37	2026-04-15 08:30:37
295	TASYA PUTRI OKTAVIA, AMD AK	20242970	tasya.putri	tasya.putri@rsazra.co.id	\N	$2y$12$jAhIjSbz2ranf4OwkLQ9iubBOCW0NhhyMaOXE2G0HpwuljJRfgvN6	4	8	Medis	ERNA SUNARNI, AMAK	aktif	\N	2026-04-15 08:30:37	2026-04-15 08:30:37
296	TETRIARIN CH. DARMO, AMK	19970291	tetriarin.ch	tetriarin.ch@rsazra.co.id	\N	$2y$12$yDnVTw3OpqJuH3JjYnt6ouEzS6VKGDvEh9zWwnUiAG3nPEv8y/.1W	5	49	Medis	IRMA RISMAYANTY, DR., MM	aktif	\N	2026-04-15 08:30:37	2026-04-15 08:30:37
297	TITA ANGGANA PUSPA	19950116	tita.anggana	tita.anggana@rsazra.co.id	\N	$2y$12$fN5rsZ5s88jGmxXFVr6JceqU3SMtuvqhrYKPmA1BSwr1gBkuEY/Ie	4	20	Non Medis	TUMPAS BANGKIT PRAYUDA, SE	aktif	\N	2026-04-15 08:30:37	2026-04-15 08:30:37
298	TRI ARYANI, A. MD	20101451	tri.aryani	tri.aryani@rsazra.co.id	\N	$2y$12$fm.1lmJ7kpQ6Jt804DnsCOh0T1YoS56mKfJUY2K2Dbqg.L.ClhEtu	4	37	Non Medis	REGAWA PARRIKESIT, A. MD	aktif	\N	2026-04-15 08:30:37	2026-04-15 08:30:37
299	TRI AYU AMALIA, A. MD	20061048	tri.ayu	tri.ayu@rsazra.co.id	\N	$2y$12$z/f7DmVIyY5BKGy0Vimx6eIGjjRsbiJDgXQP7zZq4q9MUUy5Q5RUO	4	40	Non Medis	RIA FAJARROHMI, SE	aktif	\N	2026-04-15 08:30:38	2026-04-15 08:30:38
300	TRISNA UMBARA PRIASMARA, A. MD	20111631	trisna.umbara	trisna.umbara@rsazra.co.id	\N	$2y$12$KpJgo350uIzCft2ego6cQO9wnqC.8T79Uyv9K62TnCOQmDNOsPP5e	4	37	Non Medis	REGAWA PARRIKESIT, A. MD	aktif	\N	2026-04-15 08:30:38	2026-04-15 08:30:38
301	UJANG RUKMA	20071128	ujang.rukma	ujang.rukma@rsazra.co.id	\N	$2y$12$OEqJyjQQTg8NwL3052ZJi.EHi2oqmq9sECM.8e37xgYtJ04erf2qe	4	31	Non Medis	ALFIAN KURNIAWAN	aktif	\N	2026-04-15 08:30:38	2026-04-15 08:30:38
302	ULPATUL MILLAH, S. FARM., APT	20242967	ulpatul.millah	ulpatul.millah@rsazra.co.id	\N	$2y$12$O1YfboknLFSMFTOJQ1X0T.VfLBz4u6Y0cAqejFIhPAfmBEUUFI6Yi	4	21	Medis	ELFA DIAN AGUSTINA, S.FARM, APT	aktif	\N	2026-04-15 08:30:38	2026-04-15 08:30:38
304	VERAWATY, M. FARM., APT	20252995	verawaty	verawaty@rsazra.co.id	\N	$2y$12$IDkhUMsXPnBX.ByBIDusKehKPneea4ISpyoJJTXihRYZVBWxp6DsK	6	21	Medis	ELFA DIAN AGUSTINA, S.FARM, APT	aktif	\N	2026-04-15 08:30:39	2026-04-15 08:30:39
305	VIDYAZAHRA ARASHA DEDI, A.MD. AK	20253013	vidyazahra.arasha	vidyazahra.arasha@rsazra.co.id	\N	$2y$12$wcIle/1Gnckvp9M0PyGs1eUqqSRlAv1mrFhao///mVaAUVn4PtOEy	4	8	Medis	ERNA SUNARNI, AMAK	aktif	\N	2026-04-15 08:30:39	2026-04-15 08:30:39
306	VIVI AHMALIA, S.KEP., NERS	20212775	vivi.ahmalia	vivi.ahmalia@rsazra.co.id	\N	$2y$12$MyF7O8kJO9Z8N19pCs49Gun/L/JX/fWQWXeCmOAFyWaPx6jQTIJ7W	4	10	Medis	EKA SETIA WULANNINGSIH, S.KEP	aktif	\N	2026-04-15 08:30:39	2026-04-15 08:30:39
307	WAWAN PURWANTO, S. KOM	20040809	wawan.purwanto	wawan.purwanto@rsazra.co.id	\N	$2y$12$qb4y/K6dcHVqaceTHX.X..jPGGumzFw9dWN5Gqr60aeFCDMx/WZLa	4	37	Non Medis	REGAWA PARRIKESIT, A. MD	aktif	\N	2026-04-15 08:30:39	2026-04-15 08:30:39
308	WIDA KARANTINA, AMK	20172383	wida.karantina	wida.karantina@rsazra.co.id	\N	$2y$12$//gZ0JTxy1kk2mFIlYQACeu1vLURkNgakpfz5DYtuM37L6n.FbgaW	6	15	Medis	YANTI HAPTIANI, S.KEP., NERS	aktif	\N	2026-04-15 08:30:40	2026-04-15 08:30:40
309	WIDIAWATI, S.KEP., NERS	20050985	widiawati	widiawati@rsazra.co.id	\N	$2y$12$UOP5pYEVttFtSGmV9MfDKeL61BKnRv7hmalLQdA93rfHGDMqGSuUu	4	17	Medis	ANASTASIA DIAN PARLINA, S.KEP., NERS	aktif	\N	2026-04-15 08:30:40	2026-04-15 08:30:40
310	WIDYA OKTAVYANA, A.MD. KEP	20212778	widya.oktavyana	widya.oktavyana@rsazra.co.id	\N	$2y$12$qyOX3Dls5p9FdhjGamlQNuf8SmJQA5t5JQaLXChCrTWwG/57eh2AO	4	38	Medis	YANTI HAPTIANI, S.KEP., NERS	aktif	\N	2026-04-15 08:30:40	2026-04-15 08:30:40
311	WIJIL RUMANTINI, AMD RAD	19960267	wijil.rumantini	wijil.rumantini@rsazra.co.id	\N	$2y$12$bh0H6P.HL6/X8h11bqGyLeUZRUCt9mn0Hc7v6MpvD9WJJEWcKoOOu	4	34	Medis	SEPTIAN NUGROHO, AMD. RAD	aktif	\N	2026-04-15 08:30:40	2026-04-15 08:30:40
312	WINA NATA PUTRI, S.KEP., NERS	20172348	wina.nata	wina.nata@rsazra.co.id	\N	$2y$12$aB9yR/fib7DF/3gG7qd4COTJkGb50ILAK7JuzInoL8wgaKJjQ80dC	4	22	Medis	SAMSIAH, S.KEP., NERS	aktif	\N	2026-04-15 08:30:40	2026-04-15 08:30:40
313	WISESA NANDIWARDHANA, DR	20212772	wisesa.nandiwardhana	wisesa.nandiwardhana@rsazra.co.id	\N	$2y$12$RyZbB4sJN1zQaiDn4BZ0FuPBy3Pa7Y0IcyQ4WbRiU7pC/2HvnscKa	4	32	Medis	MUHAMMAD ARDYANSYAH PRATAMA, DR	aktif	\N	2026-04-15 08:30:41	2026-04-15 08:30:41
314	WISNA MERIZKY, DR	20253046	wisna.merizky	wisna.merizky@rsazra.co.id	\N	$2y$12$cnemTi0stSfxf6D1MpaMwOO38jaZ3MH93VIwsX1VLhbqHs.JFBckG	4	32	Medis	MUHAMMAD ARDYANSYAH PRATAMA, DR	aktif	\N	2026-04-15 08:30:41	2026-04-15 08:30:41
315	WITA ROSTANIA, DR., SP.A	20111698	wita.rostania	wita.rostania@rsazra.co.id	\N	$2y$12$zvAMo5AVzeRIah2DyfypI.bRd3/LGBd2I0QfX7NRPcSMn950Rutq.	10	7	Medis	RAHAYU AFIAH SURUR, DR	aktif	\N	2026-04-15 08:30:41	2026-04-15 08:30:41
316	WULAN SARI, AMK	20172347	wulan.sari	wulan.sari@rsazra.co.id	\N	$2y$12$VWYC0qUFNKNGwQ.Djm13puljk0eaum6EXZHaFsgmYeu54LVuKMLDe	4	16	Medis	YANTI HAPTIANI, S.KEP., NERS	aktif	\N	2026-04-15 08:30:41	2026-04-15 08:30:41
317	YANA HERMAWAN, SE	20131904	yana.hermawan	yana.hermawan@rsazra.co.id	\N	$2y$12$9N8M16GBrb8oMLxcrzNgRu6iC5vnTLzkMJOzMIl7nCHf218VvRx.u	4	30	Non Medis	BUDI HARTANTO	aktif	\N	2026-04-15 08:30:42	2026-04-15 08:30:42
318	YANTI HAPTIANI, S.KEP., NERS	19980340	yanti.haptiani	yanti.haptiani@rsazra.co.id	\N	$2y$12$psDRLaZgEzjoKcfozVDNaeSSVAdXiiU1QJKtCHHfefpHdTxooMF.O	5	15	Medis	SENI MAULIDA FITALOKA, S.KEP., NERS, M.KEP	aktif	\N	2026-04-15 08:30:42	2026-04-15 08:30:42
319	YENIMANDEZA PUTRY, S.KEP., NERS	20253083	yenimandeza.putry	yenimandeza.putry@rsazra.co.id	\N	$2y$12$nzCNtvDlm5FIgOBwL3Z34e01uPmgYw1CQcpwmZcOpbajAIqeuqeUK	4	10	Medis	EKA SETIA WULANNINGSIH, S.KEP	aktif	\N	2026-04-15 08:30:42	2026-04-15 08:30:42
320	YENI ROHENDA, AMK	20061036	yeni.rohenda	yeni.rohenda@rsazra.co.id	\N	$2y$12$fiMtOtdnOa3QoC83BQD.UO3180wEQumFHF0D2cEaQICKASksMeZum	4	17	Medis	ANASTASIA DIAN PARLINA, S.KEP., NERS	aktif	\N	2026-04-15 08:30:42	2026-04-15 08:30:42
321	YENI YULIA, AMK	20050891	yeni.yulia	yeni.yulia@rsazra.co.id	\N	$2y$12$sJN0ehA3CPiaUWhzJpU/bOj3vO1pT0ThkLF5gYvOOkVzCb6.a9aw.	4	10	Medis	EKA SETIA WULANNINGSIH, S.KEP	aktif	\N	2026-04-15 08:30:42	2026-04-15 08:30:42
322	YOGI, S.FARM	20253057	yogi	yogi@rsazra.co.id	\N	$2y$12$5Sl980dZY3.Cup/lrjjcDu7EFOdqTf9rfErqvF5qaqsAuKJm615o.	4	21	Medis	ELFA DIAN AGUSTINA, S.FARM, APT	aktif	\N	2026-04-15 08:30:43	2026-04-15 08:30:43
323	YOSE SLAMET SAPUTRA, SE	20081310	yose.slamet	yose.slamet@rsazra.co.id	\N	$2y$12$6iFkd.5AV3DKk5.VaZvXleBpD6XLLWpatHf9v7OASFee.9LJ88ziO	4	43	Non Medis	M MAHFUD ISRO, S.E	aktif	\N	2026-04-15 08:30:43	2026-04-15 08:30:43
324	YULIANA, AMK	20050927	yuliana	yuliana@rsazra.co.id	\N	$2y$12$a2yvzo8MNyOU41F0acakhO9YmHQgAiMa.b6Nodj7ZO1cVjYiduwNq	5	7	Medis	SENI MAULIDA FITALOKA, S.KEP., NERS, M.KEP	aktif	\N	2026-04-15 08:30:43	2026-04-15 08:30:43
325	YULISA FADHILLAH, S.TR. DS	20242966	yulisa.fadhillah	yulisa.fadhillah@rsazra.co.id	\N	$2y$12$Bolb0bOQknNBIJTUf1utY.xbUUqf.79J/43hMU1voFEOZEI5REIZq	4	20	Non Medis	ANDRI IFTIYOKO, SH	aktif	\N	2026-04-15 08:30:43	2026-04-15 08:30:43
326	YULITA DIAN LESTARI, AM.KEB	20081267	yulita.dian	yulita.dian@rsazra.co.id	\N	$2y$12$iYphMcQ/DloDs/Zab.9Kn.LnqqOPC00H5q27K7SqgDZBtnVNlGeAe	4	44	Medis	IRENE SRI SUMARNI, AM.KEB	aktif	\N	2026-04-15 08:30:44	2026-04-15 08:30:44
327	YUNITA SARI, S.KEP., NERS	20253075	yunita.sari	yunita.sari@rsazra.co.id	\N	$2y$12$nQaE2UMV4V7XNBzxNGHK6OzJ5icyVhoovTcWHY2Cx0d4gMjRy4dHy	4	7	Medis	YULIANA, AMK	aktif	\N	2026-04-15 08:30:44	2026-04-15 08:30:44
328	YUSTIKA DAMAYANTI, S.KEP., NERS	20222879	yustika.damayanti	yustika.damayanti@rsazra.co.id	\N	$2y$12$tylstQwbAi3lTDa8Drmsr.4hiVNwF9JchlYYD44ugdRk9zWgy3eki	4	14	Medis	SRI YULIANI, S.KEP., NERS	aktif	\N	2026-04-15 08:30:44	2026-04-15 08:30:44
329	YUYUN POMADINI, AMK	20101418	yuyun.pomadini	yuyun.pomadini@rsazra.co.id	\N	$2y$12$eXYOZCUoVNNFnp0otaBoqOq7smfL6G27U00UasFPYmo.U7TitLvEe	4	38	Medis	YANTI HAPTIANI, S.KEP., NERS	aktif	\N	2026-04-15 08:30:44	2026-04-15 08:30:44
330	ZALLITA SAKTYA HARARI, A.MD. RAD	20253098	zallita.saktya	zallita.saktya@rsazra.co.id	\N	$2y$12$LCL3oAx.yAD1W/WODznV8eh1m9JxU1lTEXVjBlJtLOcnq/BZOOpZu	4	34	Medis	SEPTIAN NUGROHO, AMD. RAD	aktif	\N	2026-04-15 08:30:44	2026-04-15 08:30:44
3	DIENI ANANDA PUTRI, DR., MARS	20141969	dieni.ananda	dieni.ananda@rsazra.co.id	\N	$2y$12$WNo1clE1RpbXnLo5MRHfROT4CdFczgVuSCpxnl0IfqOUO0Dcso40C	2	2	Medis	MANAGER	aktif	\N	2026-04-15 08:29:32	2026-04-16 01:34:46
132	INTAN ANANDA UTAMI, AMD OT	20111641	intan.ananda	intan.ananda@rsazra.co.id	\N	$2y$12$i5bRVo.a0s2VKk7FbdJ3/e1wA4N2OYFlWiWczv6BrK84bOKn6nGVK	5	29	Medis	GARCINIA SATIVA FIZRIA SETIADI, DR, MKM	aktif	\N	2026-04-15 08:30:00	2026-04-16 02:53:12
303	UMAR BAIDHOWI, S. KOM	20222886	umar.baidhowi	umar.baidhowi@rsazra.co.id	\N	$2y$12$pxvrvu2w7ovdBM7Adgfb2OXLl/BmzAAS4GDx42YKueK7NyyiL8t/2	4	23	Non Medis	MUHAMAD MIFTAHUDIN, M. KOM	non-aktif	\N	2026-04-15 08:30:39	2026-04-16 03:57:18
\.


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 24, true);


--
-- Name: tbl_dimensi_mutu_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_dimensi_mutu_id_seq', 7, true);


--
-- Name: tbl_hak_akses_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_hak_akses_id_seq', 63, true);


--
-- Name: tbl_hasil_analisa_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_hasil_analisa_id_seq', 1, false);


--
-- Name: tbl_indikator_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_indikator_id_seq', 118, true);


--
-- Name: tbl_indikator_periode_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_indikator_periode_id_seq', 118, true);


--
-- Name: tbl_jenis_indikator_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_jenis_indikator_id_seq', 4, true);


--
-- Name: tbl_kamus_indikator_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_kamus_indikator_id_seq', 119, true);


--
-- Name: tbl_kategori_imprs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_kategori_imprs_id_seq', 11, true);


--
-- Name: tbl_laporan_dan_analis_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_laporan_dan_analis_id_seq', 100, true);


--
-- Name: tbl_laporan_validator_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_laporan_validator_id_seq', 31, true);


--
-- Name: tbl_metode_pengumpulan_data_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_metode_pengumpulan_data_id_seq', 2, true);


--
-- Name: tbl_pdsa_assignments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_pdsa_assignments_id_seq', 1, false);


--
-- Name: tbl_pdsa_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_pdsa_id_seq', 1, false);


--
-- Name: tbl_penyajian_data_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_penyajian_data_id_seq', 5, true);


--
-- Name: tbl_periode_analisis_data_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_periode_analisis_data_id_seq', 3, true);


--
-- Name: tbl_periode_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_periode_id_seq', 1, true);


--
-- Name: tbl_periode_pengumpulan_data_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_periode_pengumpulan_data_id_seq', 3, true);


--
-- Name: tbl_periode_unit_deadline_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_periode_unit_deadline_id_seq', 1, false);


--
-- Name: tbl_role_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_role_id_seq', 10, true);


--
-- Name: tbl_unit_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_unit_id_seq', 55, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 330, true);


--
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: tbl_dimensi_mutu tbl_dimensi_mutu_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_dimensi_mutu
    ADD CONSTRAINT tbl_dimensi_mutu_pkey PRIMARY KEY (id);


--
-- Name: tbl_hak_akses tbl_hak_akses_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_hak_akses
    ADD CONSTRAINT tbl_hak_akses_pkey PRIMARY KEY (id);


--
-- Name: tbl_hasil_analisa tbl_hasil_analisa_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_hasil_analisa
    ADD CONSTRAINT tbl_hasil_analisa_pkey PRIMARY KEY (id);


--
-- Name: tbl_indikator_periode tbl_indikator_periode_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_indikator_periode
    ADD CONSTRAINT tbl_indikator_periode_pkey PRIMARY KEY (id);


--
-- Name: tbl_indikator tbl_indikator_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_indikator
    ADD CONSTRAINT tbl_indikator_pkey PRIMARY KEY (id);


--
-- Name: tbl_jenis_indikator tbl_jenis_indikator_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_jenis_indikator
    ADD CONSTRAINT tbl_jenis_indikator_pkey PRIMARY KEY (id);


--
-- Name: tbl_kamus_indikator tbl_kamus_indikator_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_kamus_indikator
    ADD CONSTRAINT tbl_kamus_indikator_pkey PRIMARY KEY (id);


--
-- Name: tbl_kategori_imprs tbl_kategori_imprs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_kategori_imprs
    ADD CONSTRAINT tbl_kategori_imprs_pkey PRIMARY KEY (id);


--
-- Name: tbl_laporan_dan_analis tbl_laporan_dan_analis_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_laporan_dan_analis
    ADD CONSTRAINT tbl_laporan_dan_analis_pkey PRIMARY KEY (id);


--
-- Name: tbl_laporan_validator tbl_laporan_validator_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_laporan_validator
    ADD CONSTRAINT tbl_laporan_validator_pkey PRIMARY KEY (id);


--
-- Name: tbl_metode_pengumpulan_data tbl_metode_pengumpulan_data_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_metode_pengumpulan_data
    ADD CONSTRAINT tbl_metode_pengumpulan_data_pkey PRIMARY KEY (id);


--
-- Name: tbl_pdsa_assignments tbl_pdsa_assignments_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_pdsa_assignments
    ADD CONSTRAINT tbl_pdsa_assignments_pkey PRIMARY KEY (id);


--
-- Name: tbl_pdsa tbl_pdsa_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_pdsa
    ADD CONSTRAINT tbl_pdsa_pkey PRIMARY KEY (id);


--
-- Name: tbl_penyajian_data tbl_penyajian_data_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_penyajian_data
    ADD CONSTRAINT tbl_penyajian_data_pkey PRIMARY KEY (id);


--
-- Name: tbl_periode_analisis_data tbl_periode_analisis_data_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_periode_analisis_data
    ADD CONSTRAINT tbl_periode_analisis_data_pkey PRIMARY KEY (id);


--
-- Name: tbl_periode_pengumpulan_data tbl_periode_pengumpulan_data_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_periode_pengumpulan_data
    ADD CONSTRAINT tbl_periode_pengumpulan_data_pkey PRIMARY KEY (id);


--
-- Name: tbl_periode tbl_periode_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_periode
    ADD CONSTRAINT tbl_periode_pkey PRIMARY KEY (id);


--
-- Name: tbl_periode_unit_deadline tbl_periode_unit_deadline_periode_id_unit_id_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_periode_unit_deadline
    ADD CONSTRAINT tbl_periode_unit_deadline_periode_id_unit_id_unique UNIQUE (periode_id, unit_id);


--
-- Name: tbl_periode_unit_deadline tbl_periode_unit_deadline_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_periode_unit_deadline
    ADD CONSTRAINT tbl_periode_unit_deadline_pkey PRIMARY KEY (id);


--
-- Name: tbl_role tbl_role_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_role
    ADD CONSTRAINT tbl_role_pkey PRIMARY KEY (id);


--
-- Name: tbl_unit tbl_unit_kode_unit_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_unit
    ADD CONSTRAINT tbl_unit_kode_unit_unique UNIQUE (kode_unit);


--
-- Name: tbl_unit tbl_unit_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_unit
    ADD CONSTRAINT tbl_unit_pkey PRIMARY KEY (id);


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
-- Name: users users_username_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_username_unique UNIQUE (username);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- Name: tbl_laporan_dan_analis_indikator_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX tbl_laporan_dan_analis_indikator_id_index ON public.tbl_laporan_dan_analis USING btree (indikator_id);


--
-- Name: tbl_laporan_dan_analis_tanggal_laporan_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX tbl_laporan_dan_analis_tanggal_laporan_index ON public.tbl_laporan_dan_analis USING btree (tanggal_laporan);


--
-- Name: tbl_laporan_dan_analis_unit_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX tbl_laporan_dan_analis_unit_id_index ON public.tbl_laporan_dan_analis USING btree (unit_id);


--
-- PostgreSQL database dump complete
--

