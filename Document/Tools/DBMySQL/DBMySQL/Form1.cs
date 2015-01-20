using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Reflection;
using Excel;
using System.Text.RegularExpressions;
using System.IO;
using System.Runtime.InteropServices;
using System.Collections;
using System.Resources;
using System.Web;

namespace CreateTable
{
    public partial class Form1 : Form
    {
        Excel.Application xlApp ;
        Object missing = Missing.Value;
        _Workbook oBook;
        ArrayList arrTable = new ArrayList();
        //ListView控件中项的建立
        ListViewItem lvItem; //ListViewItem 成员，初学者可以暂时把该项理解为在Details模式中的一整行信息
        ListViewItem.ListViewSubItem lvSubItem; //表示 ListViewItem 的子项，也就是ListViewItem一行中的一列信息。
        Boolean IsCreateDB = true;
        string database_name = "";
        string createdb = "";
        bool IsFirst = true;
        public Form1()
        {
            xlApp = new ApplicationClass(); 
            InitializeComponent();
            lbExcel.Text = lbExcel.Text + ConfigMod.DataBasePath;
            //CreatResource();
            ResourceManager manager = new ResourceManager("CreateTable.CreateTable", Assembly.GetExecutingAssembly());
            System.Windows.Forms.ImageList imglist = new System.Windows.Forms.ImageList();
            //imglist.Images.Add((Image)manager.GetObject("success.png"));
           // imglist.Images.Add((Image)manager.GetObject("fail.png"));
            imglist.Images.Add(System.Drawing.Image.FromFile("success.png"));
            imglist.Images.Add(System.Drawing.Image.FromFile("fail.png"));

            listView1.SmallImageList = imglist;
            this.skinEngine1.SkinFile = "Page.ssk";

            InitialForm();    
        }
       
        public void InitialForm()
        {
            try
            {
                string path = System.IO.Directory.GetCurrentDirectory();
                string XlsName = ConfigMod.DataBasePath;
                if (!File.Exists(XlsName))
                {
                    listView1.Items.Add("找不到database.xls");
                    return;
                }
                //从Excel中读取功能类测试数据
                oBook = xlApp.Workbooks.Open(XlsName, missing,
                        missing, missing, missing, missing, missing, missing, missing, missing, missing, missing, missing, missing, missing);
                oBook.Activate();
                int sheetcount = oBook.Sheets.Count;
                string strlable = "";
                string strTableName = "";
                int tbcount = 0;
                _Worksheet oSheet;
                //按照数据库来创建各个表，再插入数据


                    for (int k = 1; k <= sheetcount; k++)
                    {
                        oSheet = (Excel._Worksheet)oBook.Sheets[k];
                        int introwCount = oSheet.UsedRange.Rows.Count;
                        int intcolCount = oSheet.UsedRange.Columns.Count;
                        Excel.Range objRange;
                        objRange = (Excel.Range)oSheet.Cells[1, 1];
                        object[,] row = new object[introwCount, intcolCount];
                        objRange = objRange.get_Resize(introwCount, intcolCount);
                        row = (object[,])objRange.Value2;
                        strlable = "";
                        if (k == 1)
                        {
                            database_name = row[1, 1].ToString();
                        }
                        if (row[1, 1] != null)
                        {
                            strlable = row[1, 1].ToString();
                            if (strlable.Trim().ToLower() != "table")
                                continue;
                        }
                        else
                            continue;
                        if (row[1, 2] != null)
                        {
                            strTableName = row[1, 2].ToString();
                        }



                        lvItem = new ListViewItem();
                        lvItem.Text = strTableName;
                        //lvItem.ImageIndex = 0; //如果你添加了imageslist控件并设置了关联，在此可以选择需要显示的图标。
                        lvSubItem = new System.Windows.Forms.ListViewItem.ListViewSubItem();
                        lvSubItem.Text = "等待"; //声明及设置Item的子项。
                        lvItem.SubItems.Add(lvSubItem); //将子项添加到Item中。
                        listView1.Items.Add(lvItem);
                        arrTable.Add(strTableName);
                        tbcount++;



                    }
            }
            catch (Exception err)
            {
                string strerr = "";
                strerr = err.Message;
                listView1.Items.Add(strerr);
            }
            finally
            {

            }
        }

        //点击生成按钮
        private void button1_Click(object sender, EventArgs e)
        {
            string strErr = "";
            bool IsSuccess=false;
            //如果不是第一次点击则首先重新初始化
            if (IsFirst == true)
            {

            }
            else
            {
                xlApp = new ApplicationClass();
                listView1.Items.Clear();
                InitialForm();
            }
            try
            {
                IsSuccess = GetTableSql(ref strErr);
            }
            catch (Exception err)
            {
                listView1.Items.Add(err.Message);
            }
            finally
            {

                Kill(xlApp);
                this.skinEngine1.SkinFile = null;
                DialogResult dia = new DialogResult();
                if(IsSuccess)
                {
                    dia = MessageBox.Show("生成成功！\r\n生成文件保存目录：" + ConfigMod.CreateSqlPath + " ！\r\n", "生成结束", MessageBoxButtons.OK, MessageBoxIcon.Question);
                    if (dia == DialogResult.OK)
                    {
                        button1.Text = "生成";
                        button1.Enabled = true;
                    }
                }
                else
                {
                    dia = MessageBox.Show("生成错误！\r\n错误信息：" +strErr + "！", "生成结束", MessageBoxButtons.OK, MessageBoxIcon.Question);
                    button1.Text = "生成";
                    button1.Enabled = true;
                }
                IsFirst = false;
            }

        }

        private bool GetTableSql(ref string strErr)
        {

            //创建保存每个sheet内容的Datatable
            System.Data.DataTable dttext = Creatdt();
            listView1.Items.Clear();
		    string strTablename ="";
            string strDbname = "";
		    string strData ="";
		    string strNo ="";//No
		    string strName  =""; //Name
		    string strMeaning  =""; //含义
		    string strType  ="";
		    string strLength  ="";
		    string strNotNULL  ="";
		    string strDefault  ="";
		    string strPK  ="";
            string strIdx1="";
            string strIdx2="";
		    string strMemo  ="";
		    string DataType  ="";
		    string DataMemo  ="";
            string strCreateTable = "";
            string strlable = "";
		    int FieldCount = 0;//字段数量
            int tableno = -1;
            string strDescription = "";
            string strscomment="";//oracle字段信息描述
            string strTableDes = "";//表描述信息（暂时只管oracle）
            string strOracleUser = "";//oracle user
            string strSynonym = "";//创建同义词语句
            _Worksheet oSheet;
            string strDatatype = "";//msql语句类型，是插入还是创建表
            string strdbtype=""; //数据库类型mysql、oracle
            string strsDrop = "--删除所有表\r\n"; //oracle:删除表字符串
            string strsGrant = ""; //oracle:授权
            string strDropSynom = "";//drop同义词
            int sheetNo = -1;
            try
            {  
                int sheetcount = oBook.Sheets.Count;
                //循环每个sheet
                for (int k = 1; k <= sheetcount; k++)
                {
                    sheetNo=k;
                    int startid = -1; 
                    oSheet = (Excel._Worksheet)oBook.Sheets[k];
                    int introwCount = oSheet.UsedRange.Rows.Count;
                    int intcolCount = oSheet.UsedRange.Columns.Count;
                    Excel.Range objRange;
                    objRange = (Excel.Range)oSheet.Cells[1, 1];
                    object[,] row = new object[introwCount, intcolCount];
                    objRange = objRange.get_Resize(introwCount, intcolCount);
                    row = (object[,])objRange.Value2;
                    strlable = "";
                    strDescription = "";
                    strData = "";
                    strscomment = "";//字段注释信息,用于oracle
                    strTableDes = "";
                    strOracleUser = "";
                    strsGrant = "";
                    strSynonym = "";
                    strDropSynom = "";
                    DataRow dr=dttext.NewRow();
                    // row[1, 1]为table、data、seq才有效
                    if (row[1, 1] != null)
                    {
                        strlable = row[1, 1].ToString();
                        if (strlable.Trim().ToLower() == "table")
                            strDatatype = "table";
                        else if (strlable.Trim().ToLower() == "data")
                            strDatatype = "data";
                        else if (strlable.Trim().ToLower() == "seq")
                            strDatatype = "seq";
                        else
                            continue;
                    }
                    else
                        continue;
                    //row[1, 2]为表名或者为用户名
                    if (row[1, 2] != null)
                        strTablename = row[1, 2].ToString();
                    else
                        continue;
                    if (strDatatype == "seq")
                    {
                        if(row[1,8]!=null)
                            strDbname = row[1, 8].ToString();
                        else
                            continue;
                        strdbtype = "oracle";

                    }
                    else
                    {
                        if (row[1, 11] != null)
                            strDbname = row[1, 11].ToString();
                        else
                            continue;

                        //数据库类型：mysql、 oracle
                        if (row[1, 8] != null)
                        {
                            strdbtype = row[1, 8].ToString();
                            if (strdbtype.Trim().ToLower() == "mysql")
                            {
                                strdbtype = "mysql";
                            }
                            else if (strdbtype.Trim().ToLower() == "oracle")
                            {
                                strdbtype = "oracle";
                                if (row[1, 3] != null)
                                {
                                    strOracleUser = row[1, 3].ToString();
                                }
                            }
                            else
                                continue;

                        }
                        //表描述信息
                        if (row[1, 5] != null) strTableDes = row[1, 5].ToString();
                    }
                    dr["dbName"] = strDbname;
                    dr["DbType"] = strdbtype;
                    switch(strDatatype)
                    {
                        case "table"://创建表
                            dr["Type"] = 0;
                            tableno++;
                            lvItem = new ListViewItem();
                            lvItem.Text = strTablename;
                            lvSubItem = new ListViewItem.ListViewSubItem();
                            lvSubItem.Text = "正在创建" + strTablename + "...";
                            lvItem.SubItems.Add(lvSubItem);
                            listView1.Items.Add(lvItem);
                            FieldCount = 0;
                            try
                            {
                                DataMemo = "";
                                for (int i = 4; i < introwCount + 1; i++)
                                {
                                    if (row[i, 1] != null && row[i, 2] != null)//编号、字段名称
                                    {
                                        strNo = row[i, 1].ToString().Trim();
                                    }
                                    else
                                    {
                                        continue;
                                    }
                                    if (CheckNum(strNo))
                                    {
                                        strName = "";
                                        strMeaning = "";
                                        strType = "";
                                        strLength = "";
                                        strNotNULL = "";
                                        strDefault = "";
                                        strPK = "";
                                        strIdx1 = "";
                                        strIdx2 = "";
                                        strMemo = "";

                                        if (row[i, 2] != null) strName = row[i, 2].ToString().Trim();
                                        if (row[i, 3] != null) strMeaning = row[i, 3].ToString().Trim();
                                        if (row[i, 4] != null) strType = row[i, 4].ToString().Trim().ToLower();
                                        if (row[i, 5] != null) strLength = row[i, 5].ToString().Trim();
                                        if (row[i, 6] != null) strNotNULL = row[i, 6].ToString().Trim();
                                        if (row[i, 7] != null) strDefault = row[i, 7].ToString().Trim().ToLower();
                                        if (row[i, 8] != null) strPK = row[i, 8].ToString().Trim();
                                        if (row[i, 11] != null) strMemo = row[i, 11].ToString().Trim();
                                        switch(strdbtype)
                                        {
                                            case "oracle":
                                                #region oracle创建表
                                                //类型
                                                DataType = strType;
                                                if(strType == "number" || strType == "nvarchar2" || strType == "varchar2" || strType == "char")
                                                {
                                                    if(strLength!="")
                                                    {
                                                        DataType = strType + "(" + strLength + ")";
                                                    }
                                                    if (row[i, 7] != null)
                                                    {
                                                        strDefault = row[i, 7].ToString().Trim();
                                                    }
                                                }
                                                if (strData == "")
                                                {
                                                    strData = "CREATE TABLE " + strOracleUser+"."+strTablename + "( \r\n" + strName + " " + DataType;
                                                }
                                                else
                                                {
                                                    strData = strData + "\r\n" + "," + strName + " " + DataType;
                                                }
                                                //是否允许为空
                                                if (strNotNULL == "○")
                                                {
                                                    strData = strData + " NOT NULL";
                                                }
                                                //是否关键字
                                                if (strPK == "○")
                                                {
                                                    strData = strData + " PRIMARY KEY";
                                                }
                                                //缺省值
                                                if (strDefault != "")
                                                {
                                                    if ((strType == "datetime") && strDefault == "''")
                                                    {
                                                        strData = strData + " Default NULL";
                                                    }
                                                    else
                                                    {
                                                        strData = strData + " Default " + strDefault;

                                                    }
                                                }
                                                //字段注释
                                                if (strMeaning!= "")
                                                {
                                                    strscomment = strscomment + "COMMENT ON COLUMN " + strOracleUser+"."+strTablename + "." + strName + " IS '" + strMeaning + "';\r\n";
                                                }
                                                FieldCount = FieldCount + 1;
                                                #endregion
                                                break;  
                                            case "mysql":
                                                #region mysql创建表
                                                //判断自增长：AUTO_INCREMENT 是否指定了初始值
                                                if(strDefault.ToLower()=="auto")
                                                {
                                                    strDefault = " AUTO_INCREMENT ";
                                                }
                                                //if (strDefault.Length >= 14 && strDefault.Substring(0, 14).ToLower() == "auto_increment")
                                                //{
                                                //    string strstartid = strDefault.Substring(15, strDefault.Length - 16);
                                                //    startid = Convert.ToInt32(strstartid);
                                                //}
                                                DataType = strType;
                                                if (strType == "char" || strType == "varchar")
                                                {
                                                    DataType = strType + "(" + strLength + ")";
                                                    if (row[i, 7] != null) strDefault = row[i, 7].ToString().Trim();
                                                }
                                                //类型为int或tinyint时指定长度
                                                if ((strType == "int" || strType == "tinyint" || strType == "bigint") && strLength != "")
                                                {
                                                    DataType = strType + "(" + strLength + ")";
                                                }
                                                if (strData == "")
                                                {
                                                    strData = "CREATE TABLE " + strTablename + "( ";
                                                    strData = strData + "\r\n" + strName + " " + DataType;
                                                }
                                                else
                                                {
                                                    strData = strData + "\r\n" + "," + strName + " " + DataType;
                                                }
                                                //是否允许为空
                                                if (strNotNULL == "○")
                                                {
                                                    strData = strData + " NOT NULL";
                                                }
                                                //是否关键字
                                                if (strPK == "○")
                                                {
                                                    strData = strData + " PRIMARY KEY";
                                                }
                                                //缺省值
                                                if (strDefault != "")
                                                {
                                                    //if (strDefault.Length >= 14 && strDefault.Substring(0, 14).ToLower() == "auto_increment")
                                                    //{
                                                    //    strData = strData + " auto_increment ";
                                                    //}
                                                    //else
                                                    //{
                                                        if ((strType == "datetime") && strDefault == "''")
                                                            strData = strData + " Default NULL";
                                                        else if(strDefault==" AUTO_INCREMENT ")
                                                        {
                                                            strData = strData + strDefault;
                                                        }
                                                        else 
                                                        {
                                                            strData = strData + " Default " + strDefault;

                                                        }
                                                }
                                                if (strMeaning + strMemo != "")
                                                {
                                                    strData = strData + " comment '" + strMeaning + "'";
                                                    strMemo = strMemo == string.Empty ? "" : " " + strMemo;
                                                    DataMemo = DataMemo + "\r\n" + "exec sp_addextendedproperty N'MS_Description', N" + QuotedString(strMeaning + strMemo) + ", N'user', N'dbo', N'table'," + "N'" + strTablename + "', N'column', N'" + strName + "'" + "\r\n" + "Go ";
                                                }
                                                FieldCount = FieldCount + 1;
                                                #endregion
                                                break;
                                            default:
                                                break;
                                        }
                                    }
                                }
                                if (strdbtype=="oracle")
                                {
                                    //if (strTablename != "")
                                    //    strsDrop += "Drop Table " + strOracleUser +"." + strTablename + ";\r\n";
                                    if(strTableDes!="")//添加表描述
                                    {

                                        strscomment = "\r\nCOMMENT ON TABLE " + strOracleUser + "." + strTablename + " IS '" + strTableDes + "';\r\n" + strscomment;
                                    }
                                    if(row[2,2]!=null && row[2,3]!=null)
                                    {
                                        string strSynuser = row[2, 3].ToString();
                                        string strSynTableName = row[2, 2].ToString();
                                        strSynonym = "\r\n/**************创建同义词***********/\r\ncreate synonym " + strSynuser + "." + strSynTableName + " for " + strOracleUser + "." + strTablename + ";\r\n";
                                        strDropSynom = "drop synonym " + strSynuser +"."+strSynTableName+ ";\r\n";
                                        strscomment += strSynonym;
                                        //授权
                                        strsGrant = "/**************授权***********/\r\nGRANT SELECT,INSERT,UPDATE,DELETE ON " + strOracleUser + "." + strTablename + " to " + strSynuser+";";
                                        strscomment += strsGrant;
                                    }
                                    strData = "\r\n/**************表名：" + strTablename + "  表描述:" + strTableDes + "  字段数量:" + FieldCount + "    生成时间:" + DateTime.Now.ToString() + "***********/" + "\r\n" + strDropSynom + "Drop Table " + strOracleUser + "." + strTablename + ";\r\n"
                                         + strData + "\r\n" + ");\r\n" + strscomment ;

                                }
                                if( strdbtype=="mysql")
                                    strData = "\r\n/**************表名：" + strTablename + "  表描述:" + strTableDes + "  字段数量:" + FieldCount + "    生成时间:" + DateTime.Now.ToString() + "***********/" + "\r\n" + "drop table if exists " + strTablename + ";\r\n" + strData + "\r\n" + ") " + ";\r\n";
                                listView1.Items[tableno].ImageIndex = 0;
                                listView1.Items[tableno].SubItems[1].Text = "成功";
                                strDescription = strData;
                                dr["Description"] = strDescription;
                                dttext.Rows.Add(dr);
                            }
                            catch (Exception e)
                            {
                                string strErr1 = e.Message;
                                listView1.Items[tableno].SubItems[1].Text = "失败";
                                listView1.Items[tableno].SubItems[1].Tag = strErr1;
                            }
                            break;          
                        case "data":
                            #region 插入数据
                            dr["Type"] = 1;
                            string insertdata = "";
                            switch (strdbtype)
                            {
                                case "oracle":
                                    insertdata = "Insert into " +strOracleUser+"."+ strTablename + "(";
                                    break;
                                case "mysql":
                                    insertdata = "Insert into " + strTablename + "(";
                                    break;
                                default:
                                    break; 
                            }
                            
                            string colname = "";
                            int colcount = 0;
                            for (int j = 1; j < intcolCount + 1; j++)
                            {
                                if (row[3, j] != null)
                                {
                                    colname += row[3, j].ToString() + ',';
                                    colcount++;
                                }
                            }
                            colname = colname.Substring(0, colname.Length - 1);
                            insertdata = insertdata + colname + ") values ( ";
                            if (colcount > 0)
                            {
                                for (int rr = 4; rr < introwCount + 1; rr++)
                                {
                                    string values = "";
                                    if(row[rr,1]==null)
                                    {
                                        continue;
                                    }
                                    for (int cc = 1; cc <= colcount; cc++)
                                    {
                                        if (row[rr, cc] != null)
                                        {
                                            if (row[rr, cc] .ToString().Trim().Length>1 &&row[rr, cc].ToString().Trim().Substring(0, 1) == "@")
                                            {
                                                values = values + row[rr, cc].ToString().Trim().Substring(1, row[rr, cc].ToString().Trim().Length - 1).Replace("'","''") + ",";

                                            }
                                            else
                                            {
                                                values = values + "'" + row[rr, cc].ToString().Replace("'", "''") + "',";
                                            }
                                            
                                        }
                                        else
                                        {
                                            values = values + "null,";
                                        }
                                    }
                                    values = values.Substring(0, values.Length - 1) + ") ;\r\n";
                                    if (strdbtype == "oracle")
                                        values +="commit;\r\n";

                                    strDescription += insertdata + values;
                                }
                                dr["Description"] = "\r\n"+strDescription;
                                dttext.Rows.Add(dr);
                            }
                            #endregion
                            break;
                        case "seq":
                            #region sequence
                            dr["Type"] = 2;
                            string owner=strTablename;
                             for (int rr = 4; rr < introwCount + 1; rr++)
                             {
                                string seqsingle="";
                                if (row[rr, 1] == null || row[rr, 2] == null || row[rr, 3] == null || row[rr, 4] == null || row[rr, 5] == null || row[rr, 6] == null || row[rr, 7] == null)
                                {
                                    continue;
                                }
                                seqsingle = "Drop sequence " + strTablename + "." + row[rr, 2].ToString() + ";\r\n" + "create sequence " + strTablename + "." + row[rr, 2].ToString() + " start with " + row[rr, 4].ToString() + " increment by " + row[rr, 5].ToString() + " " + row[rr, 6].ToString() + " " + row[rr, 7].ToString() + ";\r\n";
                                seqsingle+="create synonym "+row[2,2].ToString()+"."+row[rr,3].ToString() + " for "+ strTablename + "." + row[rr,2].ToString()+";\r\n";
                                seqsingle+="grant select on "+strTablename+"."+row[rr,2].ToString()+ " to "+row[2,2].ToString()+";\r\n";
                                strDescription += seqsingle;
                             }
                             dr["Description"] = "\r\n" + strDescription;
                             dttext.Rows.Add(dr);

                            #endregion
                            break;
                        default:
                            break;
                    }                    
                }
                //将mysql和oracle数据分类写到不同的文件中
                System.Data.DataTable dtcopy = dttext.Copy();
                dtcopy = dtcopy.DefaultView.ToTable(true, new string[] { "Dbname", "DbType" });
                System.Data.DataTable dtdbType = dttext.Copy();
                dtdbType = dtcopy.DefaultView.ToTable(true, new string[] { "DbType" });

                //循环数据库类型
                for (int typerow = 0; typerow < dtdbType.Rows.Count; typerow++)
                {
                    strCreateTable = "";
                    string dbname = "";
                    dtcopy.DefaultView.RowFilter="DbType='"+dtdbType.Rows[typerow]["DbType"]+ "'";
                    System.Data.DataTable dtcopyFilter = dtcopy.DefaultView.ToTable();
                    //循环某个数据库类型下各个数据库
                    for (int rr = 0; rr < dtcopyFilter.Rows.Count; rr++)
                    {
                        //oracle删除所有表
                        //if (dtdbType.Rows[typerow]["DbType"].ToString() == "oracle")
                        //{
                        //    strCreateTable += strsDrop+"\r\n";
                        //}

                        dbname = dtcopyFilter.Rows[rr]["Dbname"].ToString();
                        dttext.CaseSensitive = true;
                        dttext.DefaultView.RowFilter = "Dbname='" + dbname + "' and DbType='"+dtdbType.Rows[typerow]["DbType"]+ "'" ;
                        System.Data.DataTable dtview = dttext.DefaultView.ToTable();
                        if (IsCreateDB == true && dtdbType.Rows[typerow]["DbType"].ToString()=="mysql")
                        {
                            strCreateTable += "Create Database If Not Exists " + dbname + ";\r\nUSE " + dbname + ";\r\n";
                        }
                        //create table
                        for (int jj = 0; jj < dtview.Rows.Count; jj++)
                        {
                            if (dtview.Rows[jj]["Type"].ToString() == "0")
                            {
                                strCreateTable += dtview.Rows[jj]["Description"].ToString() + "\r\n\r\n";
                            }
                        }
                        //if (dtdbType.Rows[typerow]["DbType"].ToString() == "oracle")
                        //{
                        //   strCreateTable+= strSynonym;
                        //}
                        //sequence 
                        for (int jj = 0; jj < dtview.Rows.Count; jj++)
                        {
                            if (dtview.Rows[jj]["Type"].ToString() == "2")
                            {
                                strCreateTable += dtview.Rows[jj]["Description"].ToString() + "\r\n\r\n";
                            }
                        }
                        //insert data
                        for (int jj = 0; jj < dtview.Rows.Count; jj++)
                        {
                            if (dtview.Rows[jj]["Type"].ToString() == "1")
                            {
                                strCreateTable += dtview.Rows[jj]["Description"].ToString() + "\r\n\r\n";
                            }
                        }
                    }
                    if (dtdbType.Rows[typerow]["DbType"].ToString() == "mysql")
                    {
                        strCreateTable = " /* CREATE USER spy@'localhost' IDENTIFIED BY 'spy';\r\nCREATE USER spy@'%' IDENTIFIED BY 'spy';\r\nSET PASSWORD FOR 'spy'@'localhost' = PASSWORD('spy');\r\nSET PASSWORD FOR 'spy'@'%' = PASSWORD('spy');\r\nGRANT ALL PRIVILEGES ON spy.* TO spy@'localhost';\r\nGRANT ALL PRIVILEGES ON spy.* TO spy@'%';*/\r\n\r\n" + strCreateTable;

                    }
                    CreateSQLTXT(ConfigMod.CreateSqlPath+dtdbType.Rows[typerow]["DbType"]+"database.sql", strCreateTable);
                }
                button1.Text = "生成结束";
                button1.Enabled = false;
                return true;              
            }
            catch (Exception e)
            {
                if(sheetNo!=-1)
                {
                    strErr = "Sheet： " + sheetNo + "出错！" + e.Message;
                }
                else
                {
                    strErr = e.Message;
                }
                listView1.Items.Add(strErr);
                return false;
  
            }
}

     
        public void CreateSQLTXT(string p_strFile,string p_strData)
        {
            if (File.Exists(p_strFile))
                File.Delete(p_strFile);

            StreamWriter objStrWriter = new StreamWriter(p_strFile, false, Encoding.Default);
            
            try
            {
                // 写入当前日志信息
                objStrWriter.Write(p_strData); 
            }
            catch (Exception e)
            {
                string strErr = e.Message;
            }
            finally
            {

                if (objStrWriter != null)
                {
                    objStrWriter.Close();
                }

            }
        }
        /// <summary>
        /// 前后加'号
        /// </summary>
        /// <param name="val_Renamed"></param>
        /// <returns></returns>
        public string QuotedString(string val_Renamed)
        {

		    string strVal="";
            string QuotedString="";
		    if(val_Renamed == string.Empty)
            {
                QuotedString = "null";
		    }
            else
            {
			    strVal = val_Renamed.Replace("'", "''");
			    QuotedString = "'" + strVal + "'";
		    }
            return QuotedString;
        }


        public static bool CheckNum(string p_strInputText)
        {
            return CheckFormat(p_strInputText, 5);
        }


        public static bool CheckFormat(string p_strInputText, int p_inttype)
        {
            bool boolCheck = false;
            Regex objReg;
            switch (p_inttype)
            {
                case 1:       //Email格式检查
                    objReg = new Regex(@"\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*");
                    boolCheck = objReg.IsMatch(p_strInputText);
                    break;
                case 2:      //身份证格式检查
                    objReg = new Regex(@"^\d{15}$|^\d{17}[a-zA-Z0-9]$");
                    boolCheck = objReg.IsMatch(p_strInputText);
                    break;
                case 3:      //手机格式检查
                    objReg = new Regex(@"^\d{11,11}$");
                    boolCheck = objReg.IsMatch(p_strInputText);
                    break;
                case 4:  //邮政编码格式检查
                    objReg = new Regex(@"\d{6,6}");
                    boolCheck = objReg.IsMatch(p_strInputText);
                    break;
                case 5:      //是否数字类型检查
                    objReg = new Regex(@"^[-]?\d+[.]?\d*$");
                    boolCheck = objReg.IsMatch(p_strInputText);
                    break;
            }
            return boolCheck;
        }



        #region 关闭当前Excel进程

        [DllImport("User32.dll", CharSet = CharSet.Auto)]
        public static extern int GetWindowThreadProcessId(IntPtr hwnd, out int ID);
        /// <summary>
        /// 关闭Excel进程
        /// </summary>
        /// <param name="excel"></param>
        public static void Kill(Excel._Application excel)
        {
            try
            {
                excel.Quit();
                IntPtr t = new IntPtr(excel.Hwnd);   //得到这个句柄，具体作用是得到这块内存入口 
                int k = 0;
                GetWindowThreadProcessId(t, out k);   //得到本进程唯一标志k
                System.Diagnostics.Process p = System.Diagnostics.Process.GetProcessById(k);   //得到对进程k的引用


                p.Kill();     //关闭进程k
            }
            catch
            { }
        }

        #endregion

        private void Form1_FormClosed(object sender, FormClosedEventArgs e)
        {
            Kill(xlApp);
        }

        /// <summary>
        /// 创建表用来保存每个sheet生成的mysql内容
        /// </summary>
        /// <returns></returns>
        private System.Data.DataTable Creatdt()
        {
            System.Data.DataTable dt = new System.Data.DataTable();
            dt.Columns.Add("Dbname", typeof(string));
            dt.Columns.Add("Type",typeof(int));//0表示创建表，1表示插入数据
            dt.Columns.Add("Description", typeof(string));
            dt.Columns.Add("DbType", typeof(string));
            return dt;
        }


        private void CreatResource()
        {

            ResourceWriter rw = new ResourceWriter("CreateTable.resources");
            Icon ico = new Icon("data.ico");

            Image success = Image.FromFile("success.png");
            Image fail = Image.FromFile("fail.png");
            
            rw.AddResource("demo.ico", ico);

            rw.AddResource("success.png", success);
            rw.AddResource("fail.png", fail);
            
            rw.AddResource("MyStr", "从资源文件中读取字符串！");
            rw.Generate();
            rw.Close();
        }

        public void button2_Click(object sender, EventArgs e)
        {
            xlApp = new ApplicationClass();
            listView1.Items.Clear();
            InitialForm();
            button1.Text = "生成";
            button1.Enabled = true;
        }

        private void checkBox1_CheckedChanged(object sender, EventArgs e)
        {
            IsCreateDB = checkBox1.Checked;
        }




    }
}
