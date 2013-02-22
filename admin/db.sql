create table categories (
  id		integer		not null auto_increment,
  cvalue	varchar(250)	not null,
  npos		integer,
  ngroup	tinyint,
  primary key  (id)
) CHARSET utf8 COLLATE utf8_bin;

CREATE Table skaters (
  id		integer		not null auto_increment,
  cname		varchar(250) 	not null,
  cname_local	varchar(250),
  cplace	varchar(250),
  cteam		varchar(250),
  dbday		date,
  nrat		int,
  nnumber	varchar(20),
  norder	integer,
  ngroup	integer,
  npenalty	real,
  ncategory	integer		references categories,
  ttime		datetime,
  ttimeb	datetime,
  ttimel	int,
  nflag		int		references flags,
  primary key  (id),
  index norder_id (norder, id),
  index (ttime),
  index (ncategory),
  index (nflag)
) CHARSET utf8 COLLATE utf8_bin;

create table flags (
  ncode		int		not null,
  cpath		varchar(250)	not null,
  c2let		char(2),
  c3let		char(3),
  cvalue	varchar(250),
  primary key  (ncode)
) CHARSET utf8 COLLATE utf8_bin;

create table flags_syn (
  id		integer		not null auto_increment,
  nflag		integer		not null references flags,
  cvalue	varchar(250)	not null,
  primary key  (id),
  index (nflag),
  unique(cvalue)
) CHARSET utf8 COLLATE utf8_bin;

CREATE Table judges (
  id		integer		not null auto_increment,
  cname		varchar(250) 	not null,
  cname_local	varchar(250),
  npenalty	tinyint		not null default 0,
  nnumber	integer	 	not null,
  cpass		varchar(250) 	not null,
  primary key  (id),
  index (nnumber), index(npenalty)
) CHARSET utf8 COLLATE utf8_bin;

CREATE Table title (
  id		integer		not null auto_increment,
  cname		varchar(250) 	not null,
  cplace	varchar(250),
  ddate		date,
  cdiscip	varchar(250),
  ccategory	varchar(250),
  ntype		tinyint		not null default 0,
  ngroup	tinyint,
  njshowpen	tinyint		not null default 0,
  nname		tinyint 	default 1,
  nname_local	tinyint 	default 1,
  nplace	tinyint 	default 1,
  nteam		tinyint 	default 0,
  nnumber	tinyint 	default 0,
  nflag		tinyint 	default 1,
  nplayendsound	tinyint 	default 1,
  cftpfile	varchar(250),
  primary key  (id)
) CHARSET utf8 COLLATE utf8_bin;
/*
ntype - type of result:
0 - result of all judges;
1 - result without edge judges;
2 - result of all judges with rating of place;
3 - result without edge judges with rating of place;
*/


CREATE Table type_marks (
  id		integer		not null auto_increment,
  cvalue	varchar(250) 	not null,
  npos		integer,
  primary key  (id),
  index(npos,id)
) CHARSET utf8 COLLATE utf8_bin;
insert into type_marks (cvalue,npos) values ("Technical",1),("Artistic",2);


CREATE Table marks (
  id		integer		not null auto_increment,
  njudge	integer 	not null references judges,
  nskater	integer 	not null references skaters,
  ntype		integer 	not null references type_marks,
  nvalue	real,
  primary key	(id),
  unique	(njudge,nskater,ntype)
) CHARSET utf8 COLLATE utf8_bin;

/*CREATE Table judgeplace_descr (
  id		integer		not null auto_increment,
  primary key	(id)
)ENGINE = MEMORY;

CREATE Table judgeplace (
  --id		integer		not null auto_increment,
  descr		int	 	not null references judgeplace_descr,
  njudge	integer 	not null references judges,
  nskater	integer 	not null references skaters,
  nresult	real		not null,
  nplace	int,
  index(descr,nskater,njudge),
  index(nskater),
  index(njudge)
--,  primary key	(id)
)ENGINE = MEMORY;*/
