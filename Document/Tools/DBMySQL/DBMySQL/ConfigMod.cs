using System;
using System.Collections.Generic;
using System.Text;
using System.Configuration;

namespace CreateTable
{
    /// <summary>
    /// 创建者：lmj
    /// 功能描述：读取配置文件的类


    /// 创建日期：2010-09-19
    /// </summary>
    public class ConfigMod
    {

        /// <summary>
        /// DataBase.xls路径
        /// </summary>
        public static string DataBasePath
        {
            get
            {
                return GetConfigNodeValue("DataBasePath");
            }
        }

        /// <summary>
        /// 生成Sql路径,同Database.xls路径一致
        /// </summary>
        public static string CreateSqlPath
        {
            get
            {
                return GetConfigNodeValue("CreateSqlPath");
            }
        }
        /// <summary>
        ///  从config中读取文件信息
        /// </summary>
        /// <param name="p_strConfigNode">节点名称</param>
        /// <returns></returns>
        private static string GetConfigNodeValue(string p_strConfigNode)
        {
            if (ConfigurationManager.AppSettings[p_strConfigNode] == null)
            {
                return string.Empty;
            }
            return ConfigurationManager.AppSettings[p_strConfigNode].ToString().Trim();
        }


       public static void UpdateAppConfig(string newKey, string newValue)
        {

            bool isModified = false;
            foreach (string key in ConfigurationManager.AppSettings)
            {
                if (key == newKey)
                {
                    isModified = true;
                }
            }

            Configuration config =
            ConfigurationManager.OpenExeConfiguration(ConfigurationUserLevel.None);
            if (isModified)
            {
                config.AppSettings.Settings.Remove(newKey);
            }

            // Add an Application Setting.
            config.AppSettings.Settings.Add(newKey, newValue);
            // Save the changes in App.config file.
            config.Save(ConfigurationSaveMode.Modified);
            // Force a reload of a changed section.
            ConfigurationManager.RefreshSection("appSettings");

        }

    }

}
