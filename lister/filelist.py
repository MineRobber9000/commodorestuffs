expChrs = dict()
expChrs[5] = "{white}",
expChrs[14] = "{lower}",
expChrs[17] = "{down}",
expChrs[18] = "{rvson}",
expChrs[19] = "{home}",
expChrs[20] = "{delete}",
expChrs[28] = "{red}",
expChrs[29] = "{right}",
expChrs[30] = "{green}",
expChrs[31] = "{blue}",
expChrs[32] = " ",
expChrs[129] = "{orange}",
expChrs[133] = "{fk1}",
expChrs[134] = "{fk3}",
expChrs[135] = "{fk5}",
expChrs[136] = "{fk7}",
expChrs[137] = "{fk2}",
expChrs[138] = "{fk4}",
expChrs[139] = "{fk6}",
expChrs[140] = "{fk8}",
expChrs[142] = "{upper}",
expChrs[144] = "{black}",
expChrs[145] = "{up}",
expChrs[146] = "{rvsoff}",
expChrs[147] = "{clr}",
expChrs[148] = "{ins}",
expChrs[149] = "{brown}",
expChrs[150] = "{lred}",
expChrs[151] = "{grey1}",
expChrs[152] = "{grey2}",
expChrs[153] = "{lgreen}",
expChrs[154] = "{lblue}",
expChrs[155] = "{grey3}",
expChrs[156] = "{purple}",
expChrs[157] = "{left}",
expChrs[158] = "{yellow}",
expChrs[159] = "{cyan}"
basic4 = "END FOR NEXT DATA INPUT# INPUT DIM READ LET GOTO RUN IF RESTORE GOSUB RETURN REM STOP ON WAIT LOAD SAVE VERIFY DEF POKE PRINT# PRINT CONT LIST CLR CMD SYS OPEN CLOSE GET NEW TAB( TO FN SPC( THEN NOT STEP + - * / ^ AND OR > = < SGN INT ABS USR FRE POS SQR RND LOG EXP COS SIN TAN ATN PEEK LEN STR$ VAL ASC CHR$ LEFT$ RIGHT$ MID$ GO CONCAT DOPEN DCLOSE RECORD HEADER COLLECT BACKUP COPY APPEND DSAVE DLOAD CATALOG RENAME SCRATCH DIRECTORY DCLEAR BANK BLOAD BSAVE KEY DELETE ELSE TRAP RESUME DISPOSE PUDEF USING ERR$ INSTR {e9} {ea} {eb} {ec} {ed} {ee} {ef} {f0} {f1} {f2} {f3} {f4} {f5} {f6} {f7} {f8} {f9} {fa} {fb} {fc} {fd} {fe} {pi}".split()

def act(filedata):
	i=2
	working = True
	outlines = []
	while working:
		line = ""
		oHigh = ord(filedata[i])
		oLow = ord(filedata[i+1])
		if not (oHigh or oLow):
			working = False
			continue
		lHigh = ord(filedata[i+3])
		lLow = ord(filedata[i+2])
		lNum = lHigh*256+lLow
		line += str(lNum)+" "
		inLine = True
		first = True
		inQuotes = True
		while inLine:
			line+="TODO: finish"
			inLine = False
		working = False # I'll work on porting more tomorrow, but for right now, I gotta sleep.
